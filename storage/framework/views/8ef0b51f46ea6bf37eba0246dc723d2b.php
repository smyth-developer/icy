<!-- Offline -->
<div x-data="{ show: false }"
     x-init="window.addEventListener('offline', () => show = true); window.addEventListener('online', () => show = false);"
     x-show="show"
     x-cloak
     x-transition:enter="transition ease-out duration-3000000000"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-3000000000"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-2"
     class="fixed top-12 lg:top-0.5 right-11 w-[320px] sm:w-[350px] flex items-start gap-3 bg-gray-600 text-white p-4 rounded-lg shadow-xl z-50"
     role="alert">

    <p class="mt-0.5 text-sm font-medium leading-snug flex-1">You are currently offline. Please check your internet connection.</p>
</div>

<!-- Success -->
<?php $__sessionArgs = ['success'];
if (session()->has($__sessionArgs[0])) :
if (isset($value)) { $__sessionPrevious[] = $value; }
$value = session()->get($__sessionArgs[0]); ?>
    <div x-data="{ show: true }"
         x-cloak
         x-show="show"
         x-init="setTimeout(() => show = false, 3000); (() => { const el = document.getElementById('sound-success'); if (el) { try { el.cloneNode(true).play(); } catch(e){} } else { try { new Audio('<?php echo e(asset('storage/audio/success.mp3')); ?>').play(); } catch(e){} } })()"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-12 lg:top-0.5 right-11 w-[320px] sm:w-[350px] flex items-start gap-3 bg-green-600 text-white p-4 rounded-lg shadow-xl z-50"
         role="alert">

        <div class="pt-0.5">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <p class="mt-0.5 text-sm font-medium leading-snug flex-1"><?php echo e($value); ?></p>
    </div>
<?php unset($value);
if (isset($__sessionPrevious) && !empty($__sessionPrevious)) { $value = array_pop($__sessionPrevious); }
if (isset($__sessionPrevious) && empty($__sessionPrevious)) { unset($__sessionPrevious); }
endif;
unset($__sessionArgs); ?>
    
<!-- Error -->
<?php $__sessionArgs = ['error'];
if (session()->has($__sessionArgs[0])) :
if (isset($value)) { $__sessionPrevious[] = $value; }
$value = session()->get($__sessionArgs[0]); ?>
    <div x-data="{ show: true }"
         x-cloak
         x-show="show"
         x-init="setTimeout(() => show = false, 3000); (() => { const el = document.getElementById('sound-error'); if (el) { try { el.cloneNode(true).play(); } catch(e){} } else { try { new Audio('<?php echo e(asset('storage/audio/error.mp3')); ?>').play(); } catch(e){} } })()"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-12 lg:top-0.5 right-11 w-[320px] sm:w-[350px] flex items-start gap-3 bg-red-600 text-white p-4 rounded-lg shadow-xl z-50"
         role="alert">

        <div class="pt-0.5">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>

        <p class="mt-0.5 text-sm font-medium leading-snug flex-1"><?php echo e($value); ?></p>
    </div>
<?php unset($value);
if (isset($__sessionPrevious) && !empty($__sessionPrevious)) { $value = array_pop($__sessionPrevious); }
if (isset($__sessionPrevious) && empty($__sessionPrevious)) { unset($__sessionPrevious); }
endif;
unset($__sessionArgs); ?>

<!-- Warning -->
<?php $__sessionArgs = ['warning'];
if (session()->has($__sessionArgs[0])) :
if (isset($value)) { $__sessionPrevious[] = $value; }
$value = session()->get($__sessionArgs[0]); ?>
    <div x-data="{ show: true }"
         x-cloak
         x-show="show"
         x-init="setTimeout(() => show = false, 3000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-12 lg:top-0.5 right-11 w-[320px] sm:w-[350px] flex items-start gap-3 bg-yellow-500 text-white p-4 rounded-lg shadow-xl z-50"
         role="alert">

        <div class="pt-0.5">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
            </svg>
        </div>

        <p class="mt-0.5 text-sm font-medium leading-snug flex-1"><?php echo e($value); ?></p>
    </div>
<?php unset($value);
if (isset($__sessionPrevious) && !empty($__sessionPrevious)) { $value = array_pop($__sessionPrevious); }
if (isset($__sessionPrevious) && empty($__sessionPrevious)) { unset($__sessionPrevious); }
endif;
unset($__sessionArgs); ?>

<!-- Info -->
<?php $__sessionArgs = ['info'];
if (session()->has($__sessionArgs[0])) :
if (isset($value)) { $__sessionPrevious[] = $value; }
$value = session()->get($__sessionArgs[0]); ?>
    <div x-data="{ show: true }"
         x-cloak
         x-show="show"
         x-init="setTimeout(() => show = false, 3000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-12 lg:top-0.5 right-11 w-[320px] sm:w-[350px] flex items-start gap-3 bg-blue-600 text-white p-4 rounded-lg shadow-xl z-50"
         role="alert">

        <div class="pt-0.5">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
            </svg>
        </div>

        <p class="mt-0.5 text-sm font-medium leading-snug flex-1"><?php echo e($value); ?></p>
    </div>
<?php unset($value);
if (isset($__sessionPrevious) && !empty($__sessionPrevious)) { $value = array_pop($__sessionPrevious); }
if (isset($__sessionPrevious) && empty($__sessionPrevious)) { unset($__sessionPrevious); }
endif;
unset($__sessionArgs); ?>
<?php /**PATH /Users/smyth/Herd/icy/resources/views/components/alert-toastr.blade.php ENDPATH**/ ?>