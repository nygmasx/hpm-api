<?php

namespace App\Livewire;

use App\Models\CleaningPlan;
use Livewire\Component;

class CleaningPlanIndex extends Component
{
    public string $search = '';

    public function render()
    {
        $cleaningPlans = CleaningPlan::with('user')
        ->where('name', 'like', '%' . $this->search . '%')
        ->orWhereHas('user', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->paginate(10);

    $headers = [
        ['key' => 'date', 'label' => 'Date', 'class' => 'text-lg'],
        ['key' => 'name', 'label' => 'Nom', 'class' => 'text-lg'],
        ['key' => 'user.name', 'label' => 'Utilisateur', 'class' => 'text-lg'],
        ['key' => 'file_type', 'label' => 'Type', 'class' => 'text-lg'],
        ['key' => 'size', 'label' => 'Taille', 'class' => 'text-lg'],
        ['key' => 'created_at', 'label' => 'Date', 'class' => 'text-lg'],
    ];

        return view('livewire.cleaning-plan-index', compact('cleaningPlans', 'headers'))
            ->layout('layouts.app');
    }
}
