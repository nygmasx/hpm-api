<x-mail::message>
    {{-- Personnalisation des couleurs --}}
    <style>
        /* Couleur principale du bouton et des accents */
        .button-primary {
            background-color: #008170 !important;
            border-bottom: 8px solid #008170 !important;
        }
        .button-primary:hover {
            background-color: #1B3030 !important;
            border-bottom: 8px solid #1B3030 !important;
        }

        /* En-tête et pied de page */
        .header, .footer {
            background-color: #FFFFFF !important;
            color: #008170 !important;
        }

        /* Corps du message */
        .content {
            background-color: #FFFFFF !important;
        }

        /* Titre */
        h1 {
            color: #008170 !important;
            font-size: 24px !important;
            font-weight: bold !important;
            text-align: center !important;
            margin-bottom: 30px !important;
        }

        /* Texte principal */
        p {
            color: #333333 !important;
            font-size: 16px !important;
            line-height: 1.6 !important;
            text-align: center !important;
        }

        /* Logo et signature */
        .signature {
            color: #008170 !important;
            font-weight: bold !important;
        }
    </style>

    {{-- Contenu de l'email --}}
    <div class="content">
        <h1>Bienvenue {{ $user->name }}!</h1>

        <p>Merci d'avoir opté pour HPM.</p>

        <x-mail::button :url="config('app.url')" class="button-primary">
            Téléchargez l'application
        </x-mail::button>

        <div class="signature">
            Merci,<br>
            L'équipe HPM
        </div>
    </div>
</x-mail::message>
