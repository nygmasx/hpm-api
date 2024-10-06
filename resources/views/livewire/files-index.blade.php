@php

    $files = App\Models\File::with('user')->get();

    $users = \App\Models\User::all();

    $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-lg'],
        ['key' => 'name', 'label' => 'Nom', 'class' => 'text-lg'],
        ['key' => 'user.name', 'label' => 'Utilisateur', 'class' => 'text-lg'],
        ['key' => 'file_type', 'label' => 'Type', 'class' => 'text-lg'],
        ['key' => 'size', 'label' => 'Taille', 'class' => 'text-lg'],
        ['key' => 'date', 'label' => 'Date', 'class' => 'text-lg'],
    ];


@endphp

<div class="">
    <x-mary-header title="Fichiers" subtitle="Liste des fichiers">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-bolt" placeholder="Recherche..."/>
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel"/>
            <x-mary-button icon="o-plus" class="btn-primary" link="/files/new"/>
        </x-slot:actions>
    </x-mary-header>
    <x-mary-table :headers="$headers" :rows="$files" striped @row-click="alert($event.detail.name)">
        @scope('cell_name', $file)
        <a href="{{ Storage::url($file->path) }}"
           download="http://127.0.0.1:8000/storage/{{ $file->path }}"
           class="text-blue-600 hover:underline"
           @click.stop>
            {{ $file->name }}
        </a>
        @endscope
    </x-mary-table>
</div>
