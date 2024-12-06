<div class="">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <x-mary-header title="Dashboard" separator/>
    <div>
        <div class="flex gap-4">
            <x-mary-stat
                title="Utilisateurs"
                color="text-black"
                :value="$users"
                icon="o-users"
                tooltip="Utilisateurs"
                class="bg-white text-black h-50"
            />
            <x-mary-stat
                title="Utilisateurs"
                color="text-black"
                :value="$users"
                icon="o-users"
                tooltip="Utilisateurs"
                class="bg-white text-black h-50"
            />
            <x-mary-stat
                title="Utilisateurs"
                color="text-black"
                :value="$users"
                icon="o-users"
                tooltip="Utilisateurs"
                class="bg-white text-black h-50"
            />
            <x-mary-stat
                title="Utilisateurs"
                color="text-black"
                :value="$users"
                icon="o-users"
                tooltip="Utilisateurs"
                class="bg-white text-black h-50"
            />
        </div>
    </div>
</div>
