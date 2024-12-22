<div>
    <x-mary-header title="Plans de nettoyage" subtitle="Liste des plans" class="text-emerald-700">
        <x-slot:middle class="!justify-end">
            <x-mary-input class="bg-emerald-700 text-white placeholder-white border-0" icon="o-bolt"
                          placeholder="Recherche..." wire:model.live="search"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-plus" class="bg-emerald-700 text-white border-0" link="/cleaning-task/new"/>
        </x-slot:actions>
    </x-mary-header>

    <div class="mb-4 flex justify-between gap-4">
        <x-mary-card title="Postes de Nettoyage" class="bg-white text-black w-1/2" separator>
            <div class="flex justify-between">
                <div class="space-y-4 w-full">
                    @foreach($cleaningStations as $cleaningStation)
                        <div class="flex justify-between w-full">
                            <div class="w-2/3">
                                <p class="font-semibold text-xl">{{ $cleaningStation->name }}</p>
                                <p class="text-gray-400 text-sm truncate">{{ $cleaningStation->cleaningZone->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <x-slot:menu>
                <a href="/cleaning-stations" wire:navigate>
                    <x-mary-icon name="o-arrow-right" class="cursor-pointer"/>
                </a>
            </x-slot:menu>
        </x-mary-card>

        <x-mary-card title="Dernières Tâches Effectuées" class="bg-white text-black w-1/2" separator>
            <div class="flex justify-between">
                <div class="space-y-4 w-full">
                    @foreach($lastCleaningTasks as $lastCleaningTask)
                        <div class="flex justify-between w-full">
                            <div class="w-2/3">
                                <p class="font-semibold text-xl">{{ $lastCleaningTask->title }}</p>
                                <div class="flex flex-col gap-1">
                                    <p class="text-gray-400 text-sm truncate">
                                        {{ $lastCleaningTask->verification_type }}
                                    </p>
                                    <p class="text-gray-400 text-sm">
                                        Complété par: {{ $lastCleaningTask->completed_by }}
                                    </p>
                                    <p class="text-gray-400 text-sm">
                                        {{ \Carbon\Carbon::parse($lastCleaningTask->completed_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <x-mary-badge
                                    class="bg-emerald-600 text-white font-bold border-none"
                                    value="{{ $lastCleaningTask->estimated_time }} min"
                                />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-mary-card>
    </div>

    <x-mary-table :headers="$headers" :rows="$cleaningTasks" class="bg-emerald-700 text-white mt-4">
        @scope('actions', $cleaningTask)
        <div class="flex flex-row gap-2">
            <x-mary-button icon="o-trash" wire:click="delete({{ $cleaningTask->id }})" spinner
                           class="btn-sm bg-white text-emerald-700"/>
        </div>
        @endscope
    </x-mary-table>

    <div class="mt-4">
        {{ $cleaningTasks->links() }}
    </div>
</div>
