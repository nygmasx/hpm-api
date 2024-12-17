<div>
    <x-mary-header title="Nouvelle Tâche" subtitle="Créer des tâches pour vos clients" class="text-emerald-700"/>
    <x-mary-form wire:submit="save">
        <div class="flex gap-8">
            <div class="w-1/2 space-y-4">
                <x-mary-select
                    label="Zone de nettoyage"
                    :options="$cleaningZones"
                    wire:model.live="selectedZone"
                    option-label="name"
                    option-value="id"
                    placeholder="Sélectionnez une zone"
                    color="emerald"
                    class="bg-emerald-700 text-white"
                />

                <x-mary-select
                    label="Station de nettoyage"
                    :options="$cleaningStations"
                    wire:model="form.cleaning_station_id"
                    option-label="name"
                    option-value="id"
                    placeholder="Sélectionnez une station"
                    :disabled="!$selectedZone"
                    color="emerald"
                    class="bg-emerald-700 text-white"
                />
                <x-mary-input label="Titre" wire:model="form.title" class="bg-emerald-700 text-white"/>
                <x-mary-input label="Fréquence" wire:model="form.frequency" class="bg-emerald-700 text-white"/>
                <x-mary-input type="time" label="Temps estimé (minute)" wire:model="form.estimated_time" class="bg-emerald-700 text-white"/>
                <x-mary-input label="Produit(s)" wire:model="form.products" class="bg-emerald-700 text-white"/>
                <x-mary-input label="Quantité de produit(s)" wire:model="form.products_quantity" class="bg-emerald-700 text-white"/>
            </div>
            <div class="w-1/2 space-y-4">
                <x-mary-input label="Type de vérification" wire:model="form.verification_type" class="bg-emerald-700 text-white"/>
                <x-mary-input label="Température" wire:model="form.temperature" class="bg-emerald-700 text-white"/>
                <x-mary-input type="time" label="Temps d'action" wire:model="form.action_time" class="bg-emerald-700 text-white"/>
                <x-mary-input label="Ustensile(s)" wire:model="form.utensil" class="bg-emerald-700 text-white"/>
                <x-mary-input label="Type de rinçage" wire:model="form.rinse_type" class="bg-emerald-700 text-white"/>
                <x-mary-input label="Type de séchage" wire:model="form.drying_type" class="bg-emerald-700 text-white"/>
            </div>
        </div>

        <x-slot:actions>
            <x-mary-button label="Annuler" link="/cleaning-plans" class="bg-gray-200 text-emerald-700 border-gray-400" />
            <x-mary-button label="Envoyer" class="bg-emerald-700 text-white" type="submit" spinner="save" />
        </x-slot:actions>
    </x-mary-form>
</div>
