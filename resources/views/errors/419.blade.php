@extends('components.layouts.error')

@section('title', '419 Page Expired')

@section('error-code')
    419
@endsection

@section('error-title')
    Phiên làm việc đã hết hạn
@endsection

@section('error-description')
    Xin lỗi, phiên làm việc của bạn đã hết hạn. Vui lòng làm mới trang và thử lại. Điều này thường xảy ra khi bạn ở lại trang quá lâu hoặc có vấn đề với bảo mật.
@endsection

@section('error-image')
    <div class="relative">
        <div class="w-full max-w-md mx-auto text-center">
            <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-red-100 to-pink-100 dark:from-red-900/20 dark:to-pink-900/20 rounded-full flex items-center justify-center">
                <svg class="w-16 h-16 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Phiên hết hạn</h3>
            <p class="text-gray-600 dark:text-gray-300">Vui lòng làm mới trang để tiếp tục</p>
        </div>
        
        {{-- Floating elements for extra visual appeal --}}
        <div class="absolute -top-4 -right-4 w-8 h-8 bg-red-500 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-pink-500 rounded-full opacity-20 animate-pulse delay-1000"></div>
    </div>
@endsection

@section('error-additional')
    <div class="space-y-4">
        {{-- Why this happened --}}
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Tại sao điều này xảy ra?</h4>
                <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                    <li>• Bạn đã ở lại trang quá lâu</li>
                    <li>• Trình duyệt đã xóa cookies</li>
                    <li>• Có vấn đề với bảo mật CSRF</li>
                </ul>
            </div>
        </div>

        {{-- What you can do --}}
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Giải pháp:</h4>
                <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                    <li>• Nhấn F5 để làm mới trang</li>
                    <li>• Đăng nhập lại nếu cần thiết</li>
                    <li>• Xóa cache trình duyệt</li>
                </ul>
            </div>
        </div>

        {{-- Security Notice --}}
        <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm text-blue-800 dark:text-blue-200">
                    Đây là tính năng bảo mật để bảo vệ tài khoản của bạn
                </span>
            </div>
        </div>
    </div>
@endsection
