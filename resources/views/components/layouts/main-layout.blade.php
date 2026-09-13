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
</head>
<body class="{{ $class ?? '' }}">
@auth
<div class="min-h-screen lg:flex">
    <input id="sidebar-toggle" type="checkbox" class="peer sr-only" />

    <label for="sidebar-toggle" class="fixed inset-0 z-20 hidden bg-[#1a1b20]/30 peer-checked:block lg:hidden" aria-label="Fechar menu"></label>

    <x-partials.sidebar/>

    <div class="min-w-0 flex-1">
        <header class="flex h-20 items-center justify-between border-b border-[#e1e2e9] bg-[#f8f9ff]/95 px-5 backdrop-blur md:px-8">
            <div class="flex items-center gap-3">
                <label for="sidebar-toggle" class="grid h-11 w-11 cursor-pointer place-items-center rounded-full text-[#44474f] hover:bg-[#e8e8ef] lg:hidden" aria-label="Abrir menu">
                    <span class="material-symbols-outlined">menu</span>
                </label>
                <div>
                    <p class="text-sm font-medium text-[#73777f]">Bem-vindo de volta,</p>
                    <h1 class="text-xl font-bold tracking-tight text-[#1a1b20]">{{ Auth::user()->name }}</h1>
                </div>
            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#d8e2ff] text-sm font-bold text-[#17437a]" aria-label="Perfil do usuário">
                {{ auth()->user()->name[0] }}
            </div>
        </header>

        <main class="p-5 md:p-8">
            {{ $slot }}
        </main>
    </div>
</div>
@else
    {{ $slot }}
@endauth
</body>
</html>
