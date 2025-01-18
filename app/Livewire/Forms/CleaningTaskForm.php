<?php

namespace App\Livewire\Forms;

use App\Models\CleaningStation;
use App\Models\CleaningTask;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CleaningTaskForm extends Form
{
    #[Validate('required')]
    public $cleaning_station_id = '';

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string')]
    public $estimated_time = '';

    #[Validate('required|string')]
    public $products = '';

    #[Validate('nullable|string')]
    public $products_quantity = '';

    #[Validate('required|string')]
    public $verification_type = '';

    #[Validate('nullable|string')]
    public $temperature = '';

    #[Validate('nullable|string')]
    public $action_time = '';

    #[Validate('nullable|string')]
    public $utensil = '';

    #[Validate('nullable|string')]
    public $rinse_type = '';

    #[Validate('nullable|string')]
    public $drying_type = '';

    #[Validate('required|string')]
    public $frequency = '';

    protected function rules()
    {
        return [
            'cleaning_station_id' => ['required', 'exists:cleaning_stations,id'],
            'title' => ['required', 'string', 'max:255'],
            'estimated_time' => ['required', 'string'],
            'products' => ['required', 'string'],
            'products_quantity' => ['nullable', 'string'],
            'verification_type' => ['required', 'string'],
            'temperature' => ['nullable', 'string'],
            'action_time' => ['nullable', 'string'],
            'utensil' => ['nullable', 'string'],
            'rinse_type' => ['nullable', 'string'],
            'drying_type' => ['nullable', 'string'],
            'frequency' => ['required', 'string'],
        ];
    }

    public function store()
    {
        $validated = $this->validate();

        // Ensure cleaning_station_id is included and is an integer
        $validated['cleaning_station_id'] = (int) $this->cleaning_station_id;

        return CleaningTask::create($validated);
    }

    public function update(CleaningTask $cleaningTask)
    {
        $validated = $this->validate();

        // Ensure cleaning_station_id is included and is an integer
        $validated['cleaning_station_id'] = (int) $this->cleaning_station_id;

        return $cleaningTask->update($validated);
    }
}
