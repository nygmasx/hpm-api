@php

$users = App\Models\User::all();

$headers = [
    ['key' => 'id', 'label' => '#', 'class' => 'text-lg'],
    ['key' => 'name', 'label' => 'Nom', 'class' => 'text-lg'],
    ['key' => 'email', 'label' => 'Email', 'class' => 'text-lg'],
    ['key' => 'role', 'label' => 'Rôle', 'class' => 'text-lg'],
];

@endphp

<div class="">
    <x-mary-header title="Utilisateurs" subtitle="Liste des utilisateurs">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-bolt" placeholder="Recherche..."/>
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel"/>
            <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.postModal = true"/>
        </x-slot:actions>
    </x-mary-header>
    <x-mary-table :headers="$headers" :rows="$users" striped @row-click="alert($event.detail.name)"/>

    <x-mary-modal wire:model="postModal" class="backdrop-blur">
        <div class="mb-5">
            <x-mary-form wire:submit="save">
                <x-mary-input label="Nom" wire:model="form.name"/>
                <x-mary-input label="Email" wire:model="form.email" type="email"/>
                <x-mary-password label="Mot de passe" wire:model="form.password" right/>
                <x-mary-toggle label="Administrateur" wire:model="form.admin"/>
                <x-slot:actions>
                    <x-mary-button label="Annuler" @click="$wire.postModal = false"/>
                    <x-mary-button label="Enregistrer" class="btn-primary" type="submit" spinner="save"/>
                </x-slot:actions>
            </x-mary-form>
        </div>
    </x-mary-modal>
</div>
