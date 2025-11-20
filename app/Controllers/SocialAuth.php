<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Config\Services;
use League\OAuth2\Client\Provider\Google;
use SocialiteProviders\Apple\Provider as AppleProvider;

class SocialAuth extends BaseController
{
    // ---------------------------------------------
    // GOOGLE LOGIN
    // ---------------------------------------------
    public function google()
    {
        $provider = new Google([
            'clientId'     => getenv('GOOGLE_CLIENT_ID'),
            'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => getenv('GOOGLE_REDIRECT_URI')
        ]);

        $authUrl = $provider->getAuthorizationUrl();
        session()->set('oauth2state', $provider->getState());

        return redirect()->to($authUrl);
    }

    public function googleCallback()
    {
        $provider = new Google([
            'clientId'     => getenv('GOOGLE_CLIENT_ID'),
            'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => getenv('GOOGLE_REDIRECT_URI')
        ]);

        if ($this->request->getVar('state') !== session()->get('oauth2state')) {
            return "Invalid OAuth state";
        }

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $this->request->getVar('code')
        ]);

        $userGoogle = $provider->getResourceOwner($token);
        $email = $userGoogle->getEmail();
        $name  = $userGoogle->getName();

        return $this->loginOrRegister($email, $name);
    }

    // ---------------------------------------------
    // APPLE LOGIN
    // ---------------------------------------------
    public function apple()
    {
        $provider = new AppleProvider([
            'clientId'  => getenv('APPLE_CLIENT_ID'),
            'teamId'    => getenv('APPLE_TEAM_ID'),
            'keyFileId' => getenv('APPLE_KEY_ID'),
            'keyFilePath' => getenv('APPLE_PRIVATE_KEY_PATH'),
            'redirectUri' => getenv('APPLE_REDIRECT_URI'),
        ]);

        $authUrl = $provider->getAuthorizationUrl();
        session()->set('oauth2state', $provider->getState());

        return redirect()->to($authUrl);
    }

    public function appleCallback()
    {
        $provider = new AppleProvider([
            'clientId'  => getenv('APPLE_CLIENT_ID'),
            'teamId'    => getenv('APPLE_TEAM_ID'),
            'keyFileId' => getenv('APPLE_KEY_ID'),
            'keyFilePath' => getenv('APPLE_PRIVATE_KEY_PATH'),
            'redirectUri' => getenv('APPLE_REDIRECT_URI'),
        ]);

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $this->request->getVar('code'),
        ]);

        $appleUser = $provider->getResourceOwner($token);

        $email = $appleUser->getEmail();
        $name  = $appleUser->getName() ?? "Apple User";

        return $this->loginOrRegister($email, $name);
    }

    // ---------------------------------------------
    // REGISTER / LOGIN AUTOMATIS
    // ---------------------------------------------
    private function loginOrRegister($email, $name)
    {
        $users = new UserModel();
        $auth = Services::authentication();

        // cek user sudah ada?
        $user = $users->where('email', $email)->first();

        if (!$user) {
            // buat akun baru
            $userId = $users->insert([
                'email' => $email,
                'username' => $email,
                'fullname' => $name,
                'password_hash' => '' // karena login social tidak pakai password
            ]);
        } else {
            $userId = $user['id'];
        }

        // login user
        $auth->login($userId);

        return redirect()->to('/dashboard');
    }
}
?>