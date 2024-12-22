<?php

namespace App\Livewire;

use App\Models\CleaningPlan;
use App\Models\CleaningStation;
use App\Models\CleaningTask;
use App\Models\CleaningZone;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CleaningPlanIndex extends Component
{
    use WithPagination;

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

        $lastCleaningTasks = CleaningTask::join('users_cleaning_tasks', 'cleaning_tasks.id', '=', 'users_cleaning_tasks.cleaning_task_id')
            ->join('users', 'users.id', '=', 'users_cleaning_tasks.user_id')
            ->select(
                'cleaning_tasks.*',
                'users.name as completed_by',
                'users_cleaning_tasks.updated_at as completed_at'
            )
            ->where('users_cleaning_tasks.is_completed', true)
            ->orderBy('users_cleaning_tasks.updated_at', 'desc')
            ->limit(3)
            ->get();
        $cleaningStations = CleaningStation::with('cleaningZone')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'text-lg'],
            ['key' => 'title', 'label' => 'Titre', 'class' => 'text-lg'],
            ['key' => 'estimated_time', 'label' => 'Temps estimé (minutes)', 'class' => 'text-lg'],
            ['key' => 'products', 'label' => 'Produit(s)', 'class' => 'text-lg'],
            ['key' => 'verification_type', 'label' => 'Type de vérification', 'class' => 'text-lg'],
            ['key' => 'frequency', 'label' => 'Fréquence', 'class' => 'text-lg'],
        ];

        return view('livewire.cleaning-plan-index',
            compact('cleaningTasks', 'lastCleaningTasks', 'cleaningStations', 'headers'))
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
