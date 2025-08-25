@extends('components.layouts.error')

@section('title', '422 Unprocessable Entity')

@section('error-code')
    422
@endsection

@section('error-title')
    Dữ liệu không hợp lệ
@endsection

@section('error-description')
    Xin lỗi, dữ liệu bạn gửi không thể được xử lý. Vui lòng kiểm tra lại thông tin và đảm bảo tất cả các trường bắt buộc đã được điền đúng cách.
@endsection

@section('error-image')
    <div class="relative">
        <div class="w-full max-w-md mx-auto text-center">
            <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900/20 dark:to-pink-900/20 rounded-full flex items-center justify-center">
                <svg class="w-16 h-16 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Dữ liệu lỗi</h3>
            <p class="text-gray-600 dark:text-gray-300">Vui lòng kiểm tra lại thông tin</p>
        </div>
        
        {{-- Floating elements for extra visual appeal --}}
        <div class="absolute -top-4 -right-4 w-8 h-8 bg-purple-500 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-pink-500 rounded-full opacity-20 animate-pulse delay-1000"></div>
    </div>
@endsection

@section('error-additional')
    <div class="space-y-4">
        {{-- Common Issues --}}
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Các lỗi thường gặp:</h4>
                <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                    <li>• Trường bắt buộc chưa được điền</li>
                    <li>• Định dạng email không hợp lệ</li>
                    <li>• Mật khẩu quá ngắn hoặc yếu</li>
                    <li>• Dữ liệu không đúng định dạng</li>
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
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Bạn có thể:</h4>
                <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                    <li>• Kiểm tra lại tất cả các trường</li>
                    <li>• Đảm bảo định dạng dữ liệu đúng</li>
                    <li>• Thử lại với thông tin khác</li>
                    <li>• Liên hệ hỗ trợ nếu vấn đề tiếp tục</li>
                </ul>
            </div>
        </div>

        {{-- Validation Tips --}}
        <div class="mt-4 p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
            <div class="flex items-start space-x-2">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-purple-800 dark:text-purple-200">Mẹo kiểm tra dữ liệu:</h4>
                    <ul class="mt-1 text-sm text-purple-700 dark:text-purple-300 space-y-1">
                        <li>• Email phải có định dạng: example@domain.com</li>
                        <li>• Mật khẩu tối thiểu 8 ký tự</li>
                        <li>• Số điện thoại: 10-11 chữ số</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
