@extends('components.layouts.error')

@section('title', '500 Server Error')

@section('error-code')
    500
@endsection

@section('error-title')
    Lỗi máy chủ
@endsection

@section('error-description')
    Xin lỗi, đã xảy ra lỗi nội bộ trên máy chủ. Đội ngũ kỹ thuật đã được thông báo và đang khắc phục sự cố. Vui lòng thử lại sau.
@endsection

@section('error-image')
    <div class="relative">
        <img src="{{ asset('storage/images/sites/500.png') }}" 
             alt="500 Server Error" 
             class="w-full max-w-md mx-auto dark:filter dark:brightness-90 dark:contrast-110 transition-all duration-300"
             style="filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.1));">
        
        {{-- Floating elements for extra visual appeal --}}
        <div class="absolute -top-4 -right-4 w-8 h-8 bg-red-500 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-orange-500 rounded-full opacity-20 animate-pulse delay-1000"></div>
    </div>
@endsection

@section('error-additional')
    <div class="space-y-4">
        {{-- Status Information --}}
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Thông tin lỗi:</h4>
                <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                    <li>• Lỗi nội bộ máy chủ (500)</li>
                    <li>• Đã ghi lại thông tin lỗi</li>
                    <li>• Đội ngũ kỹ thuật đang khắc phục</li>
                </ul>
            </div>
        </div>

        {{-- What you can do --}}
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Bạn có thể:</h4>
                <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                    <li>• Thử lại sau vài phút</li>
                    <li>• Làm mới trang (F5)</li>
                    <li>• Xóa cache trình duyệt</li>
                    <li>• Liên hệ hỗ trợ nếu vấn đề tiếp tục</li>
                </ul>
            </div>
        </div>

        {{-- Contact Support --}}
        <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span class="text-sm text-blue-800 dark:text-blue-200">
                    Cần hỗ trợ? Liên hệ: <a href="mailto:support@icy.edu.com" class="font-medium hover:underline">support@icy.edu.com</a>
                </span>
            </div>
        </div>
    </div>
@endsection
