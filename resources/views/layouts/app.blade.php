<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-200">

<x-mary-main full-width>
    {{-- This is a sidebar that works also as a drawer on small screens --}}
    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-emerald-700">
        {{-- User --}}
        @if($user = auth()->user())
            <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                              class="pt-2 text-white">
                <x-slot:actions>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-mary-button type="submit" icon="o-power" class="btn-circle btn-ghost btn-xs text-white"
                                       tooltip-left="Déconnexion"/>
                    </form>
                </x-slot:actions>
            </x-mary-list-item>

            <x-mary-menu-separator/>
        @endif

        {{-- Activates the menu item when a route matches the `link` property --}}
        <x-mary-menu activate-by-route class="text-white">
            <x-mary-menu-item title="Home" icon="o-home" link="/"/>
            <x-mary-menu-item title="Utilisateurs" icon="o-users" link="/users"/>
            <x-mary-menu-item title="Fichiers" icon="s-inbox-arrow-down" link="/files"/>
            <x-mary-menu-item title="Plan de nettoyage" icon="s-sparkles" link="/cleaning-plans"/>
            <x-mary-menu-item title="Zone de nettoyage" icon="o-view-columns" link="/cleaning-zones"/>
            <x-mary-menu-item title="Poste de nettoyage" icon="o-building-library" link="/cleaning-stations"/>
        </x-mary-menu>
    </x-slot:sidebar>

    {{-- The `$slot` goes here --}}
    <x-slot:content>
        {{ $slot }}
    </x-slot:content>
</x-mary-main>

{{--  TOAST area --}}
<x-mary-toast/>
@livewireScripts
</body>
</html>
