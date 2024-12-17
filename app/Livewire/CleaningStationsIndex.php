<?php

namespace App\Livewire;

use App\Models\CleaningStation;
use Livewire\Component;

class CleaningStationsIndex extends Component
{

    public string $search = '';

    public bool $editMode = false;

    public function render()
    {
        $cleaningStations = CleaningStation::with('cleaningZone')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('cleaningZone', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'text-lg'],
            ['key' => 'name', 'label' => 'Titre', 'class' => 'text-lg'],
            ['key' => 'cleaningZone.name', 'label' => 'Zone', 'class' => 'text-lg'],
        ];

        return view('livewire.cleaning-stations-index', compact(['cleaningStations'], 'headers'))
            ->layout('layouts.app');
    }
}
