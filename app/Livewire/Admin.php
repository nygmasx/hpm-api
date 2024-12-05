<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Admin extends Component
{
    public function render()
    {
        $users = User::all()->count();

        return view('admin', ['users' => $users])
            ->layout('layouts.app');
    }
}
