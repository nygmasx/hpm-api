<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state(['password' => '']);

rules(['password' => ['required', 'string', 'current_password']]);

$cancelSubscription = function () {

    auth()->user()->subscription()->cancel();

};

?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Mon abonnement') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Une fois votre abonnement annulé, toutes ses ressources et données seront définitivement effacées.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-cancel')"
    >{{ __('Annuler') }}</x-danger-button>

    <x-modal name="confirm-user-cancel" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="cancelSubscription" class="p-6">

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Êtes-vous sûr de vouloir annuler votre abonnement ?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Une fois votre abonnement annulé, vous aurez toujours accès à vos privilèges jusqu'à la fin de celui-ci.")}}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Retour') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Annuler mon abonnement') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
