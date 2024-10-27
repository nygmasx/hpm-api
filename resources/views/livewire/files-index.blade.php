<div>
    <x-mary-header title="Fichiers" subtitle="Liste des fichiers" class="text-emerald-700">
        <x-slot:middle class="!justify-end">
            <x-mary-input class="bg-emerald-700 text-white placeholder-white border-0" icon="o-bolt" placeholder="Recherche..." wire:model.live.debounce.300ms="search"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="bg-emerald-700 text-white border-0" link="/files/new"/>
        </x-slot:actions>
    </x-mary-header>
    <x-mary-table :headers="$headers" :rows="$files" class="bg-emerald-700 text-white">
        @scope('cell_name', $file)
        <a href="{{ Storage::url($file->path) }}"
           download
           class="text-gray-300 hover:underline"
           @click.stop>
            {{ $file->name }}
        </a>
        @endscope
        @scope('cell_size', $file)
        {{ number_format($file->size / 1024, 2) }} KB
        @endscope
        @scope('cell_created_at', $file)
        {{ $file->created_at->format('d/m/Y H:i') }}
        @endscope
        @scope('actions', $file)
        <div class="flex flex-row gap-2">
            <x-mary-button icon="o-trash" wire:click="delete({{ $file->id }})" spinner class="bg-white text-emerald-700"/>
        </div>
        @endscope
    </x-mary-table>

    <div class="mt-4">
        {{ $files->links() }}
    </div>
</div>
