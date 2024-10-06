<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use Livewire\Component;

class UserIndex extends Component
{
    public bool $postModal = false;

    public UserForm $form;
    public function render()
    {
        return view('livewire.user-index')
            ->layout('layouts.app');
    }

    public function save()
    {
        $this->form->store();
        $this->postModal = false;
    }
}
