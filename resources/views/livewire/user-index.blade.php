<div class="">
    <x-mary-header title="Utilisateurs" subtitle="Liste des utilisateurs">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-bolt" placeholder="Recherche..." wire:model.live="search"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel"/>
            <x-mary-button icon="o-plus" class="btn-primary" wire:click="showModal"/>
        </x-slot:actions>
    </x-mary-header>
    <x-mary-table :headers="$headers" :rows="$users" striped>
        @scope('actions', $user)
        <div class="flex flex-row gap-2">
            <x-mary-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm"/>
            <x-mary-button icon="o-pencil" wire:click="edit({{ $user->id }})" spinner class="btn-sm"/>
        </div>
        @endscope
    </x-mary-table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <x-mary-modal wire:model="postModal" class="backdrop-blur">
        <div class="mb-5">
            <x-mary-form wire:submit="save">
                <x-mary-input label="Nom" wire:model="form.name"/>
                <x-mary-input label="Email" wire:model="form.email" type="email"/>
                <x-mary-password label="Mot de passe" wire:model="form.password" right/>
                <x-mary-toggle label="Administrateur" wire:model="form.admin"/>
                <x-slot:actions>
                    <x-mary-button label="Annuler" wire:click="$set('postModal', false)"/>
                    <x-mary-button label="Enregistrer" class="btn-primary" type="submit" spinner="save"/>
                </x-slot:actions>
            </x-mary-form>
        </div>
    </x-mary-modal>
</div>
