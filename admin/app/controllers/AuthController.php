<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Calyo\Services\AuthService;

final class AuthController extends Controller
{
    public function showLogin(Request $request): void
    {
        $this->view('auth.login', [
            'title' => 'Sign in to Calyo',
            'error' => Session::flash('error'),
            'email' => Session::flash('old_email') ?? '',
        ], 'auth');
    }

    public function login(Request $request): void
    {
        $email    = clean((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');

        if ($email === '' || $password === '') {
            Session::flash('error', 'Email and password are required.');
            Session::flash('old_email', $email);
            $this->redirect('/login');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'Please enter a valid email address.');
            Session::flash('old_email', $email);
            $this->redirect('/login');
        }

        $result = (new AuthService())->attempt($email, $password, $request->ip(), $request->userAgent());

        if (!$result['ok']) {
            Session::flash('error', $result['message']);
            Session::flash('old_email', $email);
            $this->redirect('/login');
        }

        $this->redirect('/dashboard');
    }

    public function logout(Request $request): void
    {
        (new AuthService())->logout($request->ip(), $request->userAgent());
        $this->redirect('/login');
    }
}
