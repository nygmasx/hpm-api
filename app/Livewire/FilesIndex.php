<?php

namespace App\Livewire;

use App\Livewire\Forms\FileForm;
use App\Livewire\Forms\UserForm;
use App\Models\File;
use App\Models\User;
use Livewire\Component;

class FilesIndex extends Component
{
    public function render()
    {
        return view('livewire.files-index')
            ->layout('layouts.app');
    }

    public function delete($id)
    {
        File::find($id)->delete();
    }
}
