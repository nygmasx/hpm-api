<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Component;

class UserIndex extends Component
{
    public bool $postModal = false;
    public bool $editMode = false;

    public UserForm $form;

    public function showModal()
    {
        $this->postModal = true;
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.user-index')
            ->layout('layouts.app');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->form->setUser($user);
        $this->editMode = true;
        $this->postModal = true;
    }

    public function save()
    {
        if ($this->editMode === true) {
            $this->form->update();
        } else {
            $this->form->store();
        }
        $this->postModal = false;
    }

    public function delete($id)
    {
        User::find($id)->delete();
    }
}
