<?php

namespace App\Livewire;

use App\Models\CleaningPlan;
use App\Models\CleaningStation;
use App\Models\CleaningTask;
use App\Models\CleaningZone;
use App\Models\User;
use Livewire\Component;

class CleaningPlanIndex extends Component
{
    public string $search = '';
    public bool $editMode = false;

    public function render()
    {
        $cleaningTasks = CleaningTask::with('users')
        ->where('title', 'like', '%' . $this->search . '%')
        ->orWhereHas('users', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->paginate(10);

        $lastCleaningTasks = CleaningTask::orderBy('created_at', 'desc')->paginate(3);
        $cleaningStations = CleaningStation::orderBy('created_at', 'desc')->paginate(3);

    $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-lg'],
        ['key' => 'title', 'label' => 'Titre', 'class' => 'text-lg'],
        ['key' => 'estimated_time', 'label' => 'Temps estimé (minutes)', 'class' => 'text-lg'],
        ['key' => 'products', 'label' => 'Produit(s)', 'class' => 'text-lg'],
        ['key' => 'verification_type', 'label' => 'Type de vérification', 'class' => 'text-lg'],
        ['key' => 'frequency', 'label' => 'Fréquence', 'class' => 'text-lg'],
    ];

        return view('livewire.cleaning-plan-index', compact(['cleaningTasks', 'lastCleaningTasks', 'cleaningStations'], 'headers'))
            ->layout('layouts.app');
    }

    public function delete($id)
    {
        CleaningTask::find($id)->delete();
    }

    public function edit($id)
    {
        $cleaningTask = CleaningTask::findOrFail($id);
        $this->form->setCleaningTask($cleaningTask);
        $this->editMode = true;
        $this->postModal = true;
    }

}
