<?php

namespace App\Livewire;

use App\Livewire\Forms\CleaningStationForm;
use Livewire\Component;

class CleaningStationsCreate extends Component
{
    public CleaningStationForm $form;

    public function render()
    {
        return view('livewire.cleaning-stations-create')
            ->layout('layouts.app');
    }

    public function save()
    {
        $this->form->store();

        return redirect(route('cleaning-stations.index'));
    }
}
