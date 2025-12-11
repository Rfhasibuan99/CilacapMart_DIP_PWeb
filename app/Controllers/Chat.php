<?php namespace App\Controllers;

use App\Models\ChatModel;
use App\Models\AkunModel;
use App\Models\UserStatusModel;

class Chat extends BaseController
{
    protected $chatModel;
    protected $akunModel;
    protected $statusModel;
    protected $db;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
        $this->akunModel = new AkunModel();
        $this->statusModel = new UserStatusModel();
        $this->db = \Config\Database::connect();
    }

    // show main chat page (list + optional opened room)
    public function index($receiver_id = 0)
    {
        // $receiver_id optional — if provided, open room immediately
        $data = [
            'receiver_id' => (int)$receiver_id,
            'current_user' => user()->id
        ];
        return view('chat/index', $data);
    }

    // return JSON list of users with last message & online
    public function users()
    {
        $currId = user()->id;
        $usersRaw = $this->akunModel->where('id !=', $currId)->findAll();
        $result = [];

        foreach ($usersRaw as $u) {
            // last message between current and this user
            $last = $this->db->table('chat')
                ->where(" (sender_id = {$currId} AND receiver_id = {$u['id']}) OR (sender_id = {$u['id']} AND receiver_id = {$currId}) ")
                ->orderBy('created_at', 'DESC')
                ->limit(1)
                ->get()
                ->getRowArray();

            // unread simple count (messages from user to me)
            $unread = $this->db->table('chat')
                ->where('sender_id', $u['id'])
                ->where('receiver_id', $currId)
                ->countAllResults();

            // online check
            $statusRow = $this->statusModel->find($u['id']);
            $online = false;
            if ($statusRow) {
                $lastSeen = strtotime($statusRow['last_seen']);
                if (time() - $lastSeen <= 30) $online = true;
            }

            $result[] = [
                'id' => $u['id'],
                'username' => $u['username'],
                'avatar' => $u['gambar'] ?? null,
                'last_message' => $last['message'] ?? null,
                'last_time' => $last['created_at'] ?? null,
                'unread' => $unread,
                'online' => $online
            ];
        }

        return $this->response->setJSON($result);
    }

    // room view (not used much because main index has UI), kept for direct link
    public function room($receiver_id)
    {
        $data = [
            'receiver_id' => (int)$receiver_id,
            'current_user' => user()->id,
            'receiver' => $this->akunModel->find($receiver_id)
        ];
        return view('chat/index', $data);
    }

    // send message via AJAX
    public function send()
    {
        $sender = user()->id;
        $receiver = (int)$this->request->getPost('receiver_id');
        $message = $this->request->getPost('message');

        if (!$message || !$receiver) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }

        $this->chatModel->insert([
            'sender_id' => $sender,
            'receiver_id' => $receiver,
            'message' => $message
        ]);

        return $this->response->setJSON(['status' => 'ok']);
    }

    // SSE stream for a personal 1:1 room
    public function stream($partner_id)
    {
        $current = user()->id;
        $partner_id = (int)$partner_id;

        // SSE headers
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        // prevent timeout and keep running until client disconnects
        set_time_limit(0);
        ignore_user_abort(true);

        $lastId = 0;

        while (true) {
            // get messages between current and partner; if lastId>0 fetch newer only
            $builder = $this->db->table('chat')
                ->where(" (sender_id = {$current} AND receiver_id = {$partner_id}) OR (sender_id = {$partner_id} AND receiver_id = {$current}) ");

            if ($lastId > 0) {
                $builder->where('id >', $lastId);
            }

            $messages = $builder->orderBy('created_at', 'ASC')->get()->getResultArray();

            if (!empty($messages)) {
                echo "data: " . json_encode($messages) . "\n\n";
                $lastId = end($messages)['id'];
                ob_flush();
                flush();
            } else {
                // send comment as keep-alive (some proxies)
                echo ": keep-alive\n\n";
                ob_flush();
                flush();
            }

            // small sleep to reduce CPU
            sleep(1);

            if (connection_aborted()) break;
        }
    }

    // simple ping to update online status; called every ~15s from client
    public function ping()
    {
        $uid = user()->id;
        $now = date('Y-m-d H:i:s');

        $exists = $this->statusModel->find($uid);
        if ($exists) {
            $this->statusModel->update($uid, ['last_seen' => $now]);
        } else {
            $this->statusModel->insert(['user_id' => $uid, 'last_seen' => $now]);
        }

        return $this->response->setJSON(['status' => 'ok']);
    }
}
