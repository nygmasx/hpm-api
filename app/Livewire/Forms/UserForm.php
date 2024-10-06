<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    #[Validate('string', 'required')]
    public $name;

    #[Validate('email', 'required')]
    public $email;

    #[Validate('required')]
    public $password;

    #[Validate('boolean')]
    public $admin = false;

    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->admin ? 'admin' : null,
        ]);

        $this->reset();
    }
}
