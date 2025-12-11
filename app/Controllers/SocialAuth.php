<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AkunModel;
use Myth\Auth\Models\UserModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\API\ResponseTrait;

class SocialAuth extends Controller
{
    use ResponseTrait;

    protected $userModel;
    protected $akunModel;

    public function __construct()
    {
        // Inisialisasi Models
        $this->userModel = model(UserModel::class);
        $this->akunModel = model(AkunModel::class);

        helper(['text', 'auth']);
    }

    /**
     * Menerima provider (google/apple) dan mengarahkan pengguna ke halaman otorisasi.
     * URI: /social/login/google
     */
    public function login($provider)
    {
        if (! in_array($provider, ['google', 'apple'])) {
            return redirect()->back()->with('error', 'Penyedia Social Login tidak didukung.');
        }

        try {
            $socialite = service('socialite');
            return $socialite->driver($provider)->redirect();
        } catch (\Exception $e) {
            log_message('error', 'Socialite Redirect Error: ' . $e->getMessage());
            return redirect()->to(route_to('login'))->with('error', 'Terjadi kesalahan pada koneksi social login.');
        }
    }

    /**
     * Menerima respons dari Google/Apple dan memproses login.
     * URI: /social/login/google/callback
     */
    public function callback($provider)
    {
        if (! in_array($provider, ['google', 'apple'])) {
            return redirect()->to(route_to('login'));
        }

        try {
            // Mengambil data user dari penyedia
            $socialite = service('socialite');
            $socialUser = $socialite->driver($provider)->user();
        } catch (\Exception $e) {
            log_message('error', 'Socialite Callback Error: ' . $e->getMessage());
            return redirect()->to(route_to('login'))->with('error', 'Gagal memverifikasi akun ' . ucfirst($provider) . '.');
        }

        // Proses login atau register
        return $this->loginOrRegister($socialUser, $provider);
    }

    /**
     * Register/Login otomatis berdasarkan data social user
     */
    private function loginOrRegister($socialUser, $provider)
    {
        $auth = service('authentication');

        // Cek apakah email sudah terdaftar
        $existingUser = $this->userModel->where('email', $socialUser->getEmail())->first();

        if ($existingUser) {
            // User sudah ada, langsung login
            $auth->login($existingUser);
        } else {
            // User baru, buat akun
            $dummyPassword = bin2hex(random_bytes(16));
            $username = $this->generateUniqueUsername($socialUser->getEmail());

            $userId = $this->userModel->insert([
                'email'         => $socialUser->getEmail(),
                'username'      => $username,
                'password_hash' => password_hash($dummyPassword, PASSWORD_DEFAULT),
                'active'        => 1,
            ]);

            // Update nama pengguna
            $this->akunModel->update($userId, [
                'nama_pengguna' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Social User'
            ]);

            // Login user baru
            $newUser = $this->userModel->find($userId);
            $auth->login($newUser);
        }

        return redirect()->to('/dashboard')->with('success', 'Login dengan ' . ucfirst($provider) . ' berhasil!');
    }

    /**
     * Generate unique username dari email
     */
    private function generateUniqueUsername($email)
    {
        $baseUsername = explode('@', $email)[0];
        $username = $baseUsername;
        $counter = 1;

        while ($this->userModel->where('username', $username)->first()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
?>
