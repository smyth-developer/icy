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
                input, button, select, textarea {
                    font-size: 16px !important; /* Prevents zoom on iOS */
                }
            }
        </style>
    </head>
    <body class="min-h-screen bg-neutral-100 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 auth-bg">
        <div class="flex min-h-svh flex-col items-center justify-center p-4 sm:p-6 md:p-10">
            <div class="flex w-full max-w-sm sm:max-w-md flex-col gap-4 sm:gap-6">
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-20 w-20 sm:h-30 sm:w-30 items-center justify-center rounded-md text-pink-500">
                        <x-app-logo-icon class="size-16 sm:size-20 fill-current" />
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
        @fluxScripts
    </body>
</html>
