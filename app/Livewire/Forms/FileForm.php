<?php

namespace App\Livewire\Forms;

use App\Models\File;
use Livewire\Form;
use Livewire\Attributes\Validate;

class FileForm extends Form
{
    #[Validate('required|string|max:255')]
    public $file_type = '';

    public $file;

    #[Validate('required|exists:users,id')]
    public $user_id;

    public function rules()
    {
        return [
            'file' => 'required|file|max:10240', // 10MB max file size
            'file_type' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function store()
    {
        $this->validate();

        File::create([
            'name' => $this->file->getClientOriginalName(),
            'path' => $this->file->store('files', 'public'),
            'type' => $this->file->getClientMimeType(),
            'file_type' => $this->file_type,
            'size' => $this->file->getSize(),
            'date' => now(),
            'user_id' => $this->user_id,
        ]);

        $this->reset();
    }
}
