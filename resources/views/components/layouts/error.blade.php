<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title', 'Error')</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>

<body class="min-h-screen bg-white dark:bg-black transition-colors duration-300">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-4xl w-full">
            {{-- Header với Logo --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center space-x-2 mb-4">
                    <img src="{{ asset('favicon.svg') }}" alt="ICY Logo" class="w-8 h-8">
                    <span class="text-2xl font-bold text-pink-500 dark:text-white">ICY</span>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    {{-- Image Section --}}
                    <div class="lg:w-1/2 p-8 lg:p-12 flex items-center justify-center bg-gradient-to-br from-pink-50 to-purple-50 dark:from-gray-800 dark:to-gray-900">
                        <div class="text-center">
                            @yield('error-image')
                        </div>
                    </div>

                    {{-- Content Section --}}
                    <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                        <div class="text-center lg:text-left">
                            {{-- Error Code --}}
                            <div class="mb-6">
                                <h1 class="text-6xl lg:text-8xl font-bold text-gray-900 dark:text-white mb-2">
                                    @yield('error-code')
                                </h1>
                                <div class="w-16 h-1 bg-pink-600 mx-auto lg:mx-0 rounded-full"></div>
                            </div>

                            {{-- Error Title --}}
                            <h2 class="text-2xl lg:text-3xl font-semibold text-gray-900 dark:text-white mb-4">
                                @yield('error-title')
                            </h2>

                            {{-- Error Description --}}
                            <p class="text-gray-600 dark:text-gray-300 mb-8 text-lg leading-relaxed">
                                @yield('error-description')
                            </p>

                            {{-- Action Buttons --}}
                            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                <a href="{{ route('dashboard') }}" 
                                   class="inline-flex items-center justify-center px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Về trang chủ
                                </a>
                                
                                <button onclick="history.back()" 
                                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Quay lại
                                </button>
                            </div>

                            {{-- Additional Info --}}
                            @hasSection('error-additional')
                            <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                @yield('error-additional')
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="text-center mt-8">
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    © {{ date('Y') }} ICY. Tất cả quyền được bảo lưu.
                </p>
            </div>
        </div>
    </div>

    {{-- Theme Toggle (Optional) --}}
    <div class="fixed top-4 right-4">
        <button onclick="document.documentElement.classList.toggle('dark')" 
                class="p-3 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>
    </div>
</body>
</html>
