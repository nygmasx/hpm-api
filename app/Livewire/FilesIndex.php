<?php

namespace App\Livewire;

use App\Livewire\Forms\FileForm;
use Livewire\Component;

class FilesIndex extends Component
{
    public bool $postModal = false;

    public function render()
    {
        return view('livewire.files-index')
            ->layout('layouts.app');
    }
}
