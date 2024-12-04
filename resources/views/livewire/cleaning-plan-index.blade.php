<div>
    <x-mary-header title="Plans de nettoyage" subtitle="Liste des plans" class="text-emerald-700">
        <x-slot:middle class="!justify-end">
            <x-mary-input class="bg-emerald-700 text-white placeholder-white border-0" icon="o-bolt" placeholder="Recherche..." wire:model.live="search"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="bg-emerald-700 text-white border-0" wire:click="showModal"/>
        </x-slot:actions>
    </x-mary-header>
    <div class="mb-4">
        <x-mary-stat
            title="Utilisateurs"
            color="text-white"
            value="44"
            icon="o-users"
            tooltip="Utilisateurs"
            class="bg-black text-white"
        />
    </div>
    <x-mary-table :headers="$headers" :rows="$cleaningPlans" class="bg-emerald-700 text-white">
        @scope('actions', $cleaningPlan)
        <div class="flex flex-row gap-2">
            <x-mary-button icon="o-trash" wire:click="delete({{ $cleaningPlan->id }})" spinner class="btn-sm bg-white text-emerald-700"/>
            <x-mary-button icon="o-pencil" wire:click="edit({{ $cleaningPlan->id }})" spinner class="btn-sm bg-white text-emerald-700"/>
        </div>
        @endscope
    </x-mary-table>

    <div class="mt-4">
        {{ $cleaningPlans->links() }}
    </div>

    <x-mary-modal wire:model="postModal" class="backdrop-blur" box-class="bg-white">
        <div class="mb-5">
            <x-mary-form wire:submit="save">
                <p class="text-emerald-700 text-center font-bold text-2xl">Ajouter un utilisateur</p>
                <x-mary-input label="Nom" wire:model="form.name" class="text-white bg-emerald-700"/>
                <x-mary-input label="Email" wire:model="form.email" type="email" class="text-white bg-emerald-700"/>
                <x-mary-password label="Mot de passe" wire:model="form.password" right class="text-white bg-emerald-700"/>
                <x-mary-toggle label="Administrateur" wire:model="form.admin" class="bg-emerald-700"/>
                <x-slot:actions>
                    <x-mary-button label="Annuler" class="bg-gray-200 text-emerald-700 border-0" wire:click="$set('postModal', false)"/>
                    <x-mary-button label="Enregistrer" class="bg-emerald-700 text-white border-0" type="submit" spinner="save"/>
                </x-slot:actions>
            </x-mary-form>
        </div>
    </x-mary-modal>
</div>
