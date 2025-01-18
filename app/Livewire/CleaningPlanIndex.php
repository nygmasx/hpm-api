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
            ->orderBy('created_at', 'desc')
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
            ['key' => 'id', 'label' => '#', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->id ?: '-';
            }],
            ['key' => 'title', 'label' => 'Titre', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->title ?: '-';
            }],
            ['key' => 'estimated_time', 'label' => 'Temps estimé (minutes)', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->estimated_time ? $cleaningTask->estimated_time . ' min' : '-';
            }],
            ['key' => 'products', 'label' => 'Produit(s)', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->products ?: '-';
            }],
            ['key' => 'products_quantity', 'label' => 'Quantité de produit(s)', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->products_quantity ?: '-';
            }],
            ['key' => 'verification_type', 'label' => 'Type de vérification', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->verification_type ?: '-';
            }],
            ['key' => 'temperature', 'label' => 'Température', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->temperature ? $cleaningTask->temperature . '°C' : '-';
            }],
            ['key' => 'action_time', 'label' => 'Temps d\'action', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->action_time ? $cleaningTask->action_time . ' min' : '-';
            }],
            ['key' => 'utensil', 'label' => 'Ustensile', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->utensil ?: '-';
            }],
            ['key' => 'rinse_type', 'label' => 'Type de rinçage', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->rinse_type ?: '-';
            }],
            ['key' => 'drying_type', 'label' => 'Type de séchage', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->drying_type ?: '-';
            }],
            ['key' => 'frequency', 'label' => 'Fréquence', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->frequency ?: '-';
            }],
            ['key' => 'cleaning_station_id', 'label' => 'Station de nettoyage', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->cleaningStation->name ?? '-';
            }],
            ['key' => 'created_at', 'label' => 'Créé le', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->created_at ? $cleaningTask->created_at->format('d/m/Y H:i') : '-';
            }],
            ['key' => 'updated_at', 'label' => 'Mis à jour le', 'class' => 'text-lg text-center', 'format' => function($cleaningTask) {
                return $cleaningTask->updated_at ? $cleaningTask->updated_at->format('d/m/Y H:i') : '-';
            }],
            ['key' => 'actions', 'label' => 'Actions', 'class' => 'text-lg text-center'],
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
