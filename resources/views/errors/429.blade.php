@extends('components.layouts.error')

@section('title', '429 Too Many Requests')

@section('error-code')
    429
@endsection

@section('error-title')
    Quá nhiều yêu cầu
@endsection

@section('error-description')
    Xin lỗi, bạn đã gửi quá nhiều yêu cầu trong thời gian ngắn. Vui lòng chờ một chút và thử lại sau để tránh spam và bảo vệ hệ thống.
@endsection

@section('error-image')
    <div class="relative">
        <div class="w-full max-w-md mx-auto text-center">
            <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-yellow-100 to-orange-100 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-full flex items-center justify-center">
                <svg class="w-16 h-16 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Vui lòng chờ</h3>
            <p class="text-gray-600 dark:text-gray-300">Hệ thống cần thời gian để xử lý</p>
        </div>
        
        {{-- Floating elements for extra visual appeal --}}
        <div class="absolute -top-4 -right-4 w-8 h-8 bg-yellow-500 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-orange-500 rounded-full opacity-20 animate-pulse delay-1000"></div>
    </div>
@endsection

@section('error-additional')
    <div class="space-y-4">
        {{-- Rate Limit Info --}}
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Thông tin giới hạn:</h4>
                <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                    <li>• Giới hạn: 60 yêu cầu/phút</li>
                    <li>• Thời gian chờ: 1-2 phút</li>
                    <li>• Đây là biện pháp bảo vệ hệ thống</li>
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
                    <li>• Chờ 1-2 phút rồi thử lại</li>
                    <li>• Giảm tần suất gửi yêu cầu</li>
                    <li>• Kiểm tra kết nối internet</li>
                </ul>
            </div>
        </div>

        {{-- Countdown Timer --}}
        <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
            <div class="text-center">
                <div class="text-sm text-yellow-800 dark:text-yellow-200 mb-2">
                    Thời gian chờ còn lại:
                </div>
                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400" id="countdown">
                    01:30
                </div>
            </div>
        </div>

        {{-- Auto Refresh Notice --}}
        <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span class="text-sm text-blue-800 dark:text-blue-200">
                    Trang sẽ tự động làm mới sau khi hết thời gian chờ
                </span>
            </div>
        </div>
    </div>

    <script>
        // Simple countdown timer
        let timeLeft = 90; // 1:30 in seconds
        const countdownElement = document.getElementById('countdown');
        
        const timer = setInterval(() => {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                countdownElement.textContent = '00:00';
                // Auto refresh after countdown
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        }, 1000);
    </script>
@endsection
