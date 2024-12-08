<?php

namespace App\Livewire;

use App\Livewire\Forms\CleaningTaskForm;
use App\Models\CleaningZone;
use App\Models\CleaningStation;
use App\Models\User;
use Livewire\Component;
use Mary\Traits\Toast;

class CleaningTaskCreate extends Component
{
    use Toast;

    public CleaningTaskForm $form;

    public $selectedZone = null;
    public $cleaningStations = [];

    public function mount()
    {
        $this->cleaningStations = collect();
    }

    public function updatedSelectedZone($value)
    {
        if ($value) {
            $this->cleaningStations = CleaningStation::where('cleaning_zone_id', $value)->get();
            $this->form->cleaning_station_id = null;
        } else {
            $this->cleaningStations = collect();
            $this->form->cleaning_station_id = null;
        }
    }

    public function save()
    {
        $task = $this->form->store();

        if ($task) {
            // Get all users and current timestamp
            $users = User::all();
            $now = now();

            // Create an array of user IDs with pivot data including timestamps
            $userAttachments = $users->pluck('id')
                ->mapWithKeys(function ($id) use ($now) {
                    return [$id => [
                        'is_completed' => false,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]];
                })
                ->toArray();

            // Attach the task to all users with pivot data
            $task->users()->attach($userAttachments);

            $this->success('Tâche créée avec succès!');
            return redirect()->route('cleaning-plans.index');
        }

        $this->error('Une erreur est survenue.');
    }

    public function render()
    {
        return view('livewire.cleaning-task-create', [
            'cleaningZones' => CleaningZone::all()
        ])
            ->layout('layouts.app');
    }
}
