<?php

namespace App\Livewire\Forms;

use App\Models\CleaningStation;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CleaningStationForm extends Form
{
    #[Validate('required|exists:cleaningZone,id')]
    public $cleaning_zone_id;

    #[Validate('required|string|max:255')]
    public $name = '';

    public function store()
    {
        $this->validate();

        CleaningStation::create([
            'name' => $this->name,
            'cleaning_zone_id' => $this->cleaning_zone_id,
        ]);

        $this->reset();
    }
}
