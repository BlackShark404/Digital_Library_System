<?php

namespace Core;

use Delight\Auth\Auth;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\TooManyRequestsException;

use PDO;

class AuthService
{
    private Auth $auth;

    public function __construct(PDO $pdo)
    {
        $this->auth = new Auth($pdo, null, null, false); // no automatic session_start
    }

    public function login(string $email, string $password, bool $remember = false): bool
    {
        try {
            if ($remember) {
                $this->auth->login($email, $password, (int)(60 * 60 * 24 * 7)); // 7 days
            } else {
                $this->auth->login($email, $password);
            }

            Session::set('user_id', $this->auth->getUserId());

            return true;
        } catch (InvalidEmailException |
                 InvalidPasswordException |
                 EmailNotVerifiedException |
                 TooManyRequestsException $e) {
            Session::flash('error', $e->getMessage());
            return false;
        }
    }

    public function logout(): void
    {
        $this->auth->logOutEverywhere(); // or logOut() for this session only
        Session::destroy();
        Cookie::delete('remember'); // optional cleanup if you set your own remember token
    }

    public function isLoggedIn(): bool
    {
        return $this->auth->isLoggedIn();
    }

    public function getUserId(): ?int
    {
        return $this->auth->getUserId();
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }
}
