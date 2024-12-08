<?php

namespace App\Livewire;

use App\Livewire\Forms\FileForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class FilesCreate extends Component
{
    use WithFileUploads;

    public FileForm $form;

    public function render()
    {
        return view('livewire.files-create')
            ->layout('layouts.app');
    }

    public function save()
    {
        $this->form->store();

        return redirect(route('files.index'));
    }
}
