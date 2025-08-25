@extends('components.layouts.error')

@section('title', '503 Service Unavailable')

@section('error-code')
    503
@endsection

@section('error-title')
    Dịch vụ không khả dụng
@endsection

@section('error-description')
    Xin lỗi, dịch vụ hiện đang trong quá trình bảo trì hoặc tạm thời không khả dụng. Chúng tôi đang nỗ lực khôi phục dịch vụ càng sớm càng tốt.
@endsection

@section('error-image')
    <div class="relative">
        <img src="{{ asset('storage/images/sites/503.png') }}" 
             alt="503 Service Unavailable" 
             class="w-full max-w-md mx-auto dark:filter dark:brightness-90 dark:contrast-110 transition-all duration-300"
             style="filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.1));">
        
        {{-- Floating elements for extra visual appeal --}}
        <div class="absolute -top-4 -right-4 w-8 h-8 bg-yellow-500 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-orange-500 rounded-full opacity-20 animate-pulse delay-1000"></div>
    </div>
@endsection

@section('error-additional')
    <div class="space-y-4">
        {{-- Maintenance Status --}}
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Trạng thái bảo trì:</h4>
                <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                    <li>• Hệ thống đang được bảo trì</li>
                    <li>• Cập nhật tính năng mới</li>
                    <li>• Khắc phục sự cố bảo mật</li>
                </ul>
            </div>
        </div>

        {{-- Estimated Time --}}
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Thời gian dự kiến:</h4>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                    Dịch vụ sẽ được khôi phục trong vòng 30-60 phút. Cảm ơn sự kiên nhẫn của bạn!
                </p>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="mt-4">
            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                <span>Tiến độ bảo trì</span>
                <span>75%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-2 rounded-full transition-all duration-1000 ease-out" style="width: 75%"></div>
            </div>
        </div>

        {{-- Notification Signup --}}
        <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm text-green-800 dark:text-green-200">
                    Nhận thông báo khi dịch vụ hoạt động trở lại
                </span>
            </div>
        </div>
    </div>
@endsection
