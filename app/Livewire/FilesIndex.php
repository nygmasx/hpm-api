<?php

namespace App\Livewire;

use App\Models\File;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class FilesIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $files = File::with('user')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'text-lg'],
            ['key' => 'name', 'label' => 'Nom', 'class' => 'text-lg'],
            ['key' => 'user.name', 'label' => 'Utilisateur', 'class' => 'text-lg'],
            ['key' => 'file_type', 'label' => 'Type', 'class' => 'text-lg'],
            ['key' => 'size', 'label' => 'Taille', 'class' => 'text-lg'],
            ['key' => 'created_at', 'label' => 'Date', 'class' => 'text-lg'],
        ];

        return view('livewire.files-index', compact('files', 'headers'))
            ->layout('layouts.app');
    }

    public function delete($id)
    {
        $file = File::find($id);
        if ($file) {
            Storage::delete($file->path);
            $file->delete();
            $this->dispatch('file-deleted');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
