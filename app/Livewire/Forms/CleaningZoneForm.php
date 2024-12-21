<?php

namespace App\Livewire\Forms;

use App\Models\CleaningZone;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CleaningZoneForm extends Form
{
    #[Validate('required|string')]
    public $name = '';

    public function rules()
    {
        return [
            'name' => 'required|string'
        ];
    }

    public function store()
    {
        $this->validate();

        $zone = CleaningZone::create([
            'name' => $this->name
        ]);

        User::chunk(100, function($users) use ($zone) {
            $pivotData = $users->map(function($user) use ($zone) {
                return [
                    'user_id' => $user->id,
                    'cleaning_zone_id' => $zone->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            })->toArray();

            $zone->user()->attach($pivotData);
        });

        $this->reset();

        return $zone;
    }
}
