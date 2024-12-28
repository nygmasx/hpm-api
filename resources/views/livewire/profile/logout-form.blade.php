<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/customer/login', navigate: true);
};

?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Se déconnecter') }}
        </h2>
    </header>

    <x-secondary-button wire:click="logout">
        {{ __('Déconnexion') }}
    </x-secondary-button>
</section>
