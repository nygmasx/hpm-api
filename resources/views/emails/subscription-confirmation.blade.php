<x-mail::message>
    # Bienvenue {{ $user->name }}

    Merci d'avoir opté pour HPM.

    <x-mail::button :url="config('app.url')" class="button-primary">
        Téléchargez l'application
    </x-mail::button>
    Merci,
    L'équipe HPM
</x-mail::message>
