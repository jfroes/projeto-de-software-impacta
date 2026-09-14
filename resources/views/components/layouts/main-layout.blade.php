<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>{{ $title }}</title>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .material-symbols-outlined {
            font-size: 22px;
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
        }
    </style>

    @livewireStyles
</head>
<body class="{{ $class ?? '' }}">
@auth
<div class="min-h-screen lg:flex">
    <input id="sidebar-toggle" type="checkbox" class="peer sr-only" />

    <label for="sidebar-toggle" class="fixed inset-0 z-20 hidden bg-[#1a1b20]/30 peer-checked:block lg:hidden" aria-label="Fechar menu"></label>

    @unless(request()->routeIs('new-user', 'users.confirm'))
    <x-partials.sidebar/>
    @endunless


    <div class="min-w-0 flex-1">
        <main class="p-5 md:p-8">
            {{ $slot }}
        </main>
    </div>
</div>
@else
    {{ $slot }}

@endauth
@livewireScripts
</body>
</html>
