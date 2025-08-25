@extends('components.layouts.error')

@section('title', '403 Forbidden')

@section('error-code')
    403
@endsection

@section('error-title')
    Truy cập bị từ chối
@endsection

@section('error-description')
    Xin lỗi, bạn không có quyền truy cập vào trang này. Vui lòng liên hệ với quản trị viên nếu bạn tin rằng đây là một lỗi.
@endsection

@section('error-image')
    <div class="relative">
        <img src="{{ asset('storage/images/sites/403.png') }}" 
             alt="403 Forbidden" 
             class="w-full max-w-md mx-auto dark:filter dark:brightness-90 dark:contrast-110 transition-all duration-300"
             style="filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.1));">
        
        {{-- Floating elements for extra visual appeal --}}
        <div class="absolute -top-4 -right-4 w-8 h-8 bg-pink-500 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-purple-500 rounded-full opacity-20 animate-pulse delay-1000"></div>
    </div>
@endsection

@section('error-additional')
    <div class="flex items-start space-x-3">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
        </div>
        <div>
            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Có thể bạn cần:</h4>
            <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                <li>• Đăng nhập với tài khoản có quyền truy cập</li>
                <li>• Liên hệ quản trị viên để được cấp quyền</li>
                <li>• Kiểm tra lại URL bạn đang truy cập</li>
            </ul>
        </div>
    </div>
@endsection
