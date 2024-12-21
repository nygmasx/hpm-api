<?php

namespace App\Livewire;

use App\Livewire\Forms\CleaningZoneForm;
use Livewire\Component;

class CleaningZoneCreate extends Component
{
    public CleaningZoneForm $form;

    public function render()
    {
        return view('livewire.cleaning-zone-create')
            ->layout('layouts.app');
    }

    public function save()
    {
        $this->form->store();

        return redirect(route('cleaning-zones.index'));
    }
}
