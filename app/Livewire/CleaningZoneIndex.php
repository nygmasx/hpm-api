<?php

namespace App\Livewire;

use App\Models\CleaningZone;
use Livewire\Component;
use Livewire\WithPagination;

class CleaningZoneIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $editMode = false;

    public function render()
    {
        $cleaningZones = CleaningZone::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'text-lg'],
            ['key' => 'name', 'label' => 'Titre', 'class' => 'text-lg'],
        ];

        return view('livewire.cleaning-zone-index', compact('cleaningZones', 'headers'))
            ->layout('layouts.app');
    }

    public function delete($id)
    {
        CleaningZone::find($id)->delete();
    }
}
