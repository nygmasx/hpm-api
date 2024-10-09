<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public bool $postModal = false;
    public bool $editMode = false;
    public string $search = '';

    public UserForm $form;

    public function showModal()
    {
        $this->postModal = true;
        $this->form->reset();
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate(10);

        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'text-lg'],
            ['key' => 'name', 'label' => 'Nom', 'class' => 'text-lg'],
            ['key' => 'email', 'label' => 'Email', 'class' => 'text-lg'],
            ['key' => 'role', 'label' => 'Rôle', 'class' => 'text-lg'],
        ];

        return view('livewire.user-index', compact('users', 'headers'))
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

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
