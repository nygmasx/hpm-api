@php

$users = \App\Models\User::whereNull('role')->get();

@endphp

<div>
    <x-mary-header title="Nouveau fichier" subtitle="Envoyez un fichier à vos clients" class="text-emerald-700"/>
    <x-mary-form wire:submit="save">
        <x-mary-input label="Type de fichier" wire:model="form.file_type" class="text-white bg-emerald-700 border-0"/>
        <x-mary-select label="Utilisateur" class="text-white bg-emerald-700" icon="o-user" placeholder="Sélectionnez un utilisateur" :options="$users" wire:model="form.user_id" />
        <x-mary-file wire:model="form.file" label="Fichier"/>
        <x-slot:actions>
            <x-mary-button label="Annuler" link="/files" class="bg-gray-200 text-emerald-700 border-gray-400" />
            <x-mary-button label="Envoyer" class="btn-primary" type="submit" spinner="save" class="text-white bg-emerald-700 border-0" />
        </x-slot:actions>
    </x-mary-form>

</div>
