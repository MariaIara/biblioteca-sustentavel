<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Biblioteca Sustentável</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#1e3a8a]">

<div class="min-h-screen flex">
    {{-- Left panel: branding --}}
    <div class="hidden lg:flex lg:flex-1 flex-col justify-center items-center bg-[#1e3a8a] px-12 relative overflow-hidden">
        {{-- Decorative circles --}}
        <div class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-32 -right-32 h-[500px] w-[500px] rounded-full bg-white/5"></div>
        <div class="absolute top-1/3 left-1/4 h-64 w-64 rounded-full bg-amber-500/10"></div>

        <div class="relative z-10 text-center max-w-sm">
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-amber-500 shadow-2xl">
                <svg class="h-11 w-11 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-3">Biblioteca Sustentável</h1>
            <p class="text-blue-200 text-lg leading-relaxed">
                Promovendo a cultura e a troca de conhecimento na empresa.
            </p>

            <div class="mt-10 grid grid-cols-3 gap-4 text-center">
                <div class="rounded-2xl bg-white/10 px-4 py-4">
                    <p class="text-2xl font-bold text-amber-400">♻️</p>
                    <p class="text-xs text-blue-200 mt-1">Sustentável</p>
                </div>
                <div class="rounded-2xl bg-white/10 px-4 py-4">
                    <p class="text-2xl font-bold text-amber-400">📚</p>
                    <p class="text-xs text-blue-200 mt-1">Acervo</p>
                </div>
                <div class="rounded-2xl bg-white/10 px-4 py-4">
                    <p class="text-2xl font-bold text-amber-400">🤝</p>
                    <p class="text-xs text-blue-200 mt-1">Compartilhar</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Right panel: form --}}
    <div class="flex flex-1 flex-col justify-center items-center bg-slate-50 px-6 py-12 sm:px-12 lg:max-w-md xl:max-w-lg">
        <div class="w-full max-w-sm">
            {{-- Mobile logo --}}
            <div class="lg:hidden flex items-center gap-3 mb-8 justify-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500 shadow">
                    <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-slate-800">Biblioteca Sustentável</span>
            </div>

            <h2 class="text-2xl font-bold text-slate-800 mb-1">Bem-vindo!</h2>
            <p class="text-slate-500 text-sm mb-8">Faça login para acessar o painel administrativo.</p>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="form-label">E-mail</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        value="{{ old('email') }}"
                        placeholder="admin@empresa.com"
                        class="form-input @error('email') border-red-400 focus:ring-red-200 @enderror"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="form-label">Senha</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        placeholder="••••••••"
                        class="form-input @error('password') border-red-400 focus:ring-red-200 @enderror"
                    >
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                    <label for="remember" class="text-sm text-slate-600">Manter conectado</label>
                </div>

                <button type="submit"
                    class="w-full rounded-xl bg-[#1e3a8a] px-4 py-3 text-sm font-semibold text-white shadow-md hover:bg-[#1e3270] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition-all duration-200">
                    Entrar no sistema
                </button>
            </form>

            <p class="mt-8 text-center text-xs text-slate-400">
                Acesso restrito a administradores autorizados.
            </p>
        </div>
    </div>
</div>

</body>
</html>
