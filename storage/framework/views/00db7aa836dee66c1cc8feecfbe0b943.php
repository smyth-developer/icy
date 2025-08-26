<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="dark">

<head>
    <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

            input,
            button,
            select,
            textarea {
                font-size: 16px !important;
                /* Prevents zoom on iOS */
            }
        }
    </style>
</head>

<body
    class="min-h-screen bg-neutral-100 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 auth-bg">
    <div class="flex min-h-svh flex-col items-center justify-center p-4 sm:p-6 md:p-10">
        <div class="flex w-full max-w-sm sm:max-w-md flex-col gap-4 sm:gap-6">
            <a href="<?php echo e(route('dashboard')); ?>" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                <span class="flex h-20 w-20 sm:h-30 sm:w-30 items-center justify-center rounded-md text-pink-500">
                    <?php if (isset($component)) { $__componentOriginal159d6670770cb479b1921cea6416c26c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal159d6670770cb479b1921cea6416c26c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-logo-icon','data' => ['class' => 'size-16 sm:size-20 fill-current']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-logo-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-16 sm:size-20 fill-current']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal159d6670770cb479b1921cea6416c26c)): ?>
<?php $attributes = $__attributesOriginal159d6670770cb479b1921cea6416c26c; ?>
<?php unset($__attributesOriginal159d6670770cb479b1921cea6416c26c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal159d6670770cb479b1921cea6416c26c)): ?>
<?php $component = $__componentOriginal159d6670770cb479b1921cea6416c26c; ?>
<?php unset($__componentOriginal159d6670770cb479b1921cea6416c26c); ?>
<?php endif; ?>
                </span>
                <span class="sr-only"><?php echo e(config('app.name', 'Laravel')); ?></span>
            </a>
            <div class="flex flex-col gap-4 sm:gap-6">
                <div class="rounded-2xl border-3 border-pink-500 bg-white dark:bg-stone-950 text-stone-800 shadow-xs">
                    <div class="px-4 py-6 sm:px-6 sm:py-8"><?php echo e($slot); ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="fixed top-4 right-4">
        <button onclick="document.documentElement.classList.toggle('dark')"
            class="p-3 bg-white dark:bg-gray-800 rounded-lg shadow-lg border-2 border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>
    </div>
    <?php app('livewire')->forceAssetInjection(); ?>
<?php echo app('flux')->scripts(); ?>

</body>

</html>
<?php /**PATH /Users/smyth/Herd/icy/resources/views/components/layouts/auth/card.blade.php ENDPATH**/ ?>