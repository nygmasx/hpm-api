<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user = null;

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|max:255')]
    public $email = '';

    public $password = '';

    #[Validate('boolean')]
    public $admin = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255' . ($this->user ? '|unique:users,email,' . $this->user->id : '|unique:users,email'),
            'password' => $this->user ? 'nullable|string|min:8' : 'required|string|min:8',
            'admin' => 'boolean',
        ];
    }

    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->admin ? 'admin' : null,
        ]);

        $this->reset('name', 'email', 'password', 'admin');
    }

    public function update()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->admin ? 'admin' : null,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);

        $this->reset('user', 'name', 'email', 'password', 'admin');
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->admin = $user->role === 'admin';
    }
}
