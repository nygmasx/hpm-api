<div class="">
    <x-mary-header title="Fichiers" subtitle="Liste des fichiers">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-bolt" placeholder="Recherche..." wire:model.live.debounce.300ms="search"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel"/>
            <x-mary-button icon="o-plus" class="btn-primary" link="/files/new"/>
        </x-slot:actions>
    </x-mary-header>
    <x-mary-table :headers="$headers" :rows="$files" striped>
        @scope('cell_name', $file)
        <a href="{{ Storage::url($file->path) }}"
           download
           class="text-blue-600 hover:underline"
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
            <x-mary-button icon="o-trash" wire:click="delete({{ $file->id }})" spinner class="btn-sm"/>
        </div>
        @endscope
    </x-mary-table>

    <div class="mt-4">
        {{ $files->links() }}
    </div>
</div>
