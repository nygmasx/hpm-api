@php

$users = \App\Models\User::whereNull('role')->get();

@endphp

<div>
    <x-mary-header title="Nouveau fichier" subtitle="Envoyez un fichier à vos clients"/>
    <x-mary-form wire:submit="save">
        <x-mary-input label="Type de fichier" wire:model="form.file_type" />
        <x-mary-select label="Utilisateur" icon="o-user" placeholder="Sélectionnez un utilisateur" :options="$users" wire:model="form.user_id" />
        <x-mary-file wire:model="form.file" label="Fichier"/>
        <x-slot:actions>
            <x-mary-button label="Annuler" link="/files"/>
            <x-mary-button label="Envoyer" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-mary-form>

</div>
