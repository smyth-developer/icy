<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <style>
        .auth-bg {
            background: #000 url('/storage/images/sites/mobie.png') no-repeat center center / cover;
        }

        @media (min-width: 1024px) {
            .auth-bg {
                background-image: url('/storage/images/sites/desktop.png');
            }
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {

            input,
            button,
            select,
            textarea {
                font-size: 16px !important;
                /* Prevents zoom on iOS */
            }
        }
    </style>
</head>

<body
    class="min-h-screen bg-neutral-100 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 auth-bg">
    <div class="flex min-h-svh flex-col items-center justify-center p-4 sm:p-6 md:p-10">
        <div class="flex w-full max-w-sm sm:max-w-md flex-col gap-4 sm:gap-6">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                <span class="flex h-20 w-20 sm:h-30 sm:w-30 items-center justify-center rounded-md text-pink-500">
                    <x-app-logo-icon class="w-90 h-90" />
                </span>
                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <div class="flex flex-col gap-4 sm:gap-6">
                <div class="rounded-2xl border-3 border-pink-500 bg-white dark:bg-stone-950 text-stone-800 shadow-xs">
                    <div class="px-4 py-6 sm:px-6 sm:py-8">{{ $slot }}</div>
                </div>
            </div>
        </div>
    </div>
    {{-- Theme Toggle (Optional) --}}
    <div class="fixed top-4 right-4">
        <button onclick="document.documentElement.classList.toggle('dark')"
            class="p-3 bg-white dark:bg-gray-800 rounded-lg shadow-lg border-2 border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>
    </div>
    @fluxScripts
</body>

</html>
