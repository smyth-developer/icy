@extends('components.layouts.error')

@section('title', '404 Not Found')

@section('error-code')
    404
@endsection

@section('error-title')
    Trang không tồn tại
@endsection

@section('error-description')
    Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển. Vui lòng kiểm tra lại URL hoặc sử dụng thanh tìm kiếm bên dưới.
@endsection

@section('error-image')
    <div class="relative">
        <img src="{{ asset('storage/images/sites/404.png') }}" 
             alt="404 Not Found" 
             class="w-full max-w-md mx-auto dark:filter dark:brightness-90 dark:contrast-110 transition-all duration-300"
             style="filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.1));">
        
        {{-- Floating elements for extra visual appeal --}}
        <div class="absolute -top-4 -right-4 w-8 h-8 bg-pink-500 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-purple-500 rounded-full opacity-20 animate-pulse delay-1000"></div>
    </div>
@endsection

@section('error-additional')
    <div class="space-y-4">
        {{-- Search Box --}}
        <div class="flex items-center space-x-2">
            <div class="flex-1 relative">
                <input type="text" 
                       placeholder="Tìm kiếm trang..." 
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1 text-gray-400 hover:text-pink-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Trang phổ biến:</h4>
                <div class="mt-2 flex flex-wrap gap-2">
                    <a href="{{ route('dashboard') }}" class="text-sm text-pink-600 dark:text-pink-400 hover:underline">Bảng điều khiển</a>
                    <span class="text-gray-400">•</span>
                    <a href="{{ route('admin.management.locations') }}" class="text-sm text-pink-600 dark:text-pink-400 hover:underline">Cơ sở</a>
                    <span class="text-gray-400">•</span>
                    <a href="{{ route('admin.management.programs') }}" class="text-sm text-pink-600 dark:text-pink-400 hover:underline">Chương trình học</a>
                </div>
            </div>
        </div>
    </div>
@endsection
