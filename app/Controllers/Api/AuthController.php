<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
            return $this->response->setStatusCode(200);
        }

        /** @var \CodeIgniter\HTTP\IncomingRequest $request */
        $request = $this->request;

        $body = $request->getBody();
        $json = json_decode($body);

        if (!empty($json)) {
            $login    = $json->login ?? null;
            $password = $json->password ?? null;
        } else {
            $login    = $request->getPost('login') ?? $request->getVar('login');
            $password = $request->getPost('password') ?? $request->getVar('password');
        }

        if (empty($login) || empty($password)) {
            return $this->respond([
                 'login' => $login,
                    'password' => $password
            ]);
            // return $this->respond([
            //     'status'  => 0,
            //     'message' => 'Email/Username dan Password tidak boleh kosong.'
            // ], 400);
        }

        $users = model(UserModel::class);

        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = $users->where($type, $login)->first();

        if ($user) {
            if ($user->active == 0) {
                return $this->respond([
                    'status'  => 0,
                    'message' => 'Akun Anda belum aktif.'
                ], 403);
            }

            $passwordHashed = base64_encode(hash('sha384', $password, true));

       if (password_verify($passwordHashed, $user->password_hash)) {

    $db = \Config\Database::connect();

    $group = $db->table('auth_groups_users agu')
        ->select('ag.name')
        ->join('auth_groups ag', 'ag.id = agu.group_id')
        ->where('agu.user_id', $user->id)
        ->get()
        ->getRow();

    return $this->respond([
        'status'  => 1,
        'message' => 'Login Berhasil ke CilacapMart!',
        'data'    => [
            'id'       => (int) $user->id,
            'username' => (string) $user->username,
            'email'    => (string) $user->email,
            'role'     => $group->name ?? 'user',
        ]
    ], 200);
}
    }

        return $this->respond([
            'status'  => 0,
            'message' => 'Email/Username atau Password Anda salah.'
        ], 401);
    }
}