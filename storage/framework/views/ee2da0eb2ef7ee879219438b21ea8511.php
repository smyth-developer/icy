<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name')); ?> - <?php echo $__env->yieldContent('title', 'Error'); ?></title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo app('flux')->fluxAppearance(); ?>

</head>

<body class="min-h-screen bg-white dark:bg-black transition-colors duration-300">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-4xl w-full">
            
            <div class="text-center mb-8">
                <div class="inline-flex items-center space-x-2 mb-4">
                    <img src="<?php echo e(asset('favicon.svg')); ?>" alt="ICY Logo" class="w-8 h-8">
                    <span class="text-2xl font-bold text-pink-500 dark:text-white">ICY</span>
                </div>
            </div>

            
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    
                    <div class="lg:w-1/2 p-8 lg:p-12 flex items-center justify-center bg-gradient-to-br from-pink-50 to-purple-50 dark:from-gray-800 dark:to-gray-900">
                        <div class="text-center">
                            <?php echo $__env->yieldContent('error-image'); ?>
                        </div>
                    </div>

                    
                    <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                        <div class="text-center lg:text-left">
                            
                            <div class="mb-6">
                                <h1 class="text-6xl lg:text-8xl font-bold text-gray-900 dark:text-white mb-2">
                                    <?php echo $__env->yieldContent('error-code'); ?>
                                </h1>
                                <div class="w-16 h-1 bg-pink-600 mx-auto lg:mx-0 rounded-full"></div>
                            </div>

                            
                            <h2 class="text-2xl lg:text-3xl font-semibold text-gray-900 dark:text-white mb-4">
                                <?php echo $__env->yieldContent('error-title'); ?>
                            </h2>

                            
                            <p class="text-gray-600 dark:text-gray-300 mb-8 text-lg leading-relaxed">
                                <?php echo $__env->yieldContent('error-description'); ?>
                            </p>

                            
                            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                <a href="<?php echo e(route('dashboard')); ?>" 
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

                            
                            <?php if (! empty(trim($__env->yieldContent('error-additional')))): ?>
                            <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <?php echo $__env->yieldContent('error-additional'); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="text-center mt-8">
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    © <?php echo e(date('Y')); ?> ICY. Tất cả quyền được bảo lưu.
                </p>
            </div>
        </div>
    </div>

    
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
<?php /**PATH /Users/smyth/Herd/icy/resources/views/components/layouts/error.blade.php ENDPATH**/ ?>