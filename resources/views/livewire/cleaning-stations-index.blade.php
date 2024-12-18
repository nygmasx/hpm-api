<div>
    <x-mary-header title="Postes de nettoyage" subtitle="Liste des postes de nettoyages" class="text-emerald-700">
        <x-slot:middle class="!justify-end">
            <x-mary-input class="bg-emerald-700 text-white placeholder-white border-0" icon="o-bolt"
                          placeholder="Recherche..." wire:model.live="search"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="bg-emerald-700 text-white border-0" link="/cleaning-station/new"/>
        </x-slot:actions>
    </x-mary-header>
    <x-mary-table :headers="$headers" :rows="$cleaningStations" class="bg-emerald-700 text-white mt-4">
        @scope('actions', $cleaningStation)
        <div class="flex flex-row gap-2">
            <x-mary-button icon="o-trash" wire:click="delete({{ $cleaningStation->id }})" spinner
                           class="btn-sm bg-white text-emerald-700"/>
        </div>
        @endscope
    </x-mary-table>

    <div class="mt-4">
        {{ $cleaningStations->links() }}
    </div>
</div>
