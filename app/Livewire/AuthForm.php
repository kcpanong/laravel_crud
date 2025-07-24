<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AuthForm extends Component
{
    public $isLogin = true;
    public $name, $email, $password, $password_confirmation, $remember = false;

    protected function rules()
    {
        return $this->isLogin ? [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ] : [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function toggleMode()
    {
        $this->resetValidation();
        $this->isLogin = !$this->isLogin;
    }

    public function authenticate()
    {
        $this->validate();

        if ($this->isLogin) {
            if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                session()->regenerate();
                return $this->redirect('/products', navigate: true);
            }

            $this->addError('email', 'Invalid credentials.');
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            Auth::login($user, true);
            return $this->redirect('/products', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.auth-form');
    }
}
