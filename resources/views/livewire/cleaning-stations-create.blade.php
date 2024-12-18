@php

    $cleaningZones = \App\Models\CleaningZone::all();

@endphp

<div>
    <x-mary-header title="Nouveau Poste" subtitle="Créer des postes liés aux zones de nettoyage "
                   class="text-emerald-700"/>
    <x-mary-form wire:submit="save">
        <div class="w-full space-y-4">
            <x-mary-select label="Zone de nettoyage" class="text-white bg-emerald-700" icon="o-user"
                           placeholder="Sélectionnez une zone de nettoyage" :options="$cleaningZones"
                           wire:model="form.cleaning_zone_id"/>
            <x-mary-input label="Nom" wire:model="form.name" class="bg-emerald-700 text-white"/>
        </div>

        <x-slot:actions>
            <x-mary-button label="Annuler" link="/cleaning-plans" class="bg-gray-200 text-emerald-700 border-gray-400"/>
            <x-mary-button label="Envoyer" class="bg-emerald-700 text-white" type="submit" spinner="save"/>
        </x-slot:actions>
    </x-mary-form>
</div>
