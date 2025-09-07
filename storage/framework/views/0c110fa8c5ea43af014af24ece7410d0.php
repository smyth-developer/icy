<div class="bg-gray-50 dark:bg-gray-900 h-full">

    
    <div class="p-6 h-full">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full">

            
            <div class="lg:col-span-2 space-y-4 flex flex-col">

                
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm flex-shrink-0" style="height: 300px;">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        📚 Chương trình hiện có
                    </h3>

                    
                    <!--[if BLOCK]><![endif]--><?php if(count($filteredPrograms) > 0): ?>
                        <div class="grid grid-cols-1 gap-2 overflow-y-auto" style="height: calc(100% - 60px);">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $filteredPrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4 flex items-center justify-between hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <div class="flex-1">
                                        <div class="text-gray-900 dark:text-white font-medium mb-1">
                                            <?php echo e($program['name']); ?>

                                        </div>
                                        <div class="text-blue-600 dark:text-blue-400 text-sm font-bold">
                                            <?php echo e(number_format($program['price'], 0, ',', '.')); ?> VNĐ
                                        </div>
                                    </div>
                                    <button wire:click="addProgram(<?php echo e($program['id']); ?>)"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-300 flex items-center shadow-sm">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Thêm
                                    </button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.709M15 6.75a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div class="text-gray-500 dark:text-gray-400 text-lg">Không tìm thấy chương trình nào</div>
                            <div class="text-gray-400 dark:text-gray-500 text-sm mt-1">Hãy thử tìm kiếm với từ khóa khác</div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm flex-1 flex flex-col">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center flex-shrink-0">
                        🛒 Đơn hàng đã chọn
                    </h3>

                    <!--[if BLOCK]><![endif]--><?php if(count($selectedItems) > 0): ?>
                        <div class="space-y-2 overflow-y-auto flex-1">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="text-gray-900 dark:text-white font-medium mb-1"><?php echo e($item['name']); ?></div>
                                            <div class="text-blue-600 dark:text-blue-400 text-sm font-bold">
                                                <?php echo e(number_format($item['price'], 0, ',', '.')); ?> VNĐ
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="flex items-center space-x-2 mr-3">
                                            <button wire:click="decreaseQuantity(<?php echo e($index); ?>)"
                                                class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                            
                                            <span class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded px-3 py-1 text-gray-900 dark:text-white font-medium min-w-[3rem] text-center">
                                                <?php echo e($item['quantity'] ?? 1); ?>

                                            </span>
                                            
                                            <button wire:click="increaseQuantity(<?php echo e($index); ?>)"
                                                class="bg-blue-600 hover:bg-blue-700 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        
                                        <button wire:click="removeItem(<?php echo e($index); ?>)"
                                            class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition-all duration-300 shadow-sm">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    
                                    <div class="mt-2 text-right">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Thành tiền: </span>
                                        <span class="text-green-600 dark:text-green-400 font-bold">
                                            <?php echo e(number_format(($item['price'] * ($item['quantity'] ?? 1)), 0, ',', '.')); ?> VNĐ
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400 text-lg">Chưa có chương trình nào được chọn</div>
                            <div class="text-gray-400 dark:text-gray-500 text-sm mt-1">Hãy chọn chương trình từ danh sách bên trên</div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

            
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 shadow-sm flex flex-col h-full">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center flex-shrink-0">

                    💳 Thanh toán
                </h2>

                
                <div class="space-y-4 mb-6 flex-1 overflow-y-auto">
                    <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-700 dark:text-gray-300 font-medium">Tổng tiền:</span>
                            <span
                                class="text-gray-900 dark:text-white font-bold text-lg"><?php echo e(number_format($totalAmount, 0, ',', '.')); ?>

                                VNĐ</span>
                        </div>

                        <div class="mb-2">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Giảm giá:</span>
                                <div class="flex items-center space-x-2">
                                    <input type="number" wire:model.live="discountAmount" placeholder="0"
                                        class="w-20 px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-right">
                                    <select wire:model.live="discountType"
                                        class="px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm">
                                        <option value="vnd">VNĐ</option>
                                        <option value="percent">%</option>
                                    </select>
                                </div>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($discountAmount > 0): ?>
                                <div class="text-right text-sm text-gray-600 dark:text-gray-400">
                                    <!--[if BLOCK]><![endif]--><?php if($discountType === 'percent'): ?>
                                        = <?php echo e(number_format(($totalAmount * $discountAmount) / 100, 0, ',', '.')); ?> VNĐ
                                    <?php else: ?>
                                        = <?php echo e(number_format($discountAmount, 0, ',', '.')); ?> VNĐ
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-600 pt-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-900 dark:text-white font-bold text-lg">Thành tiền:</span>
                                <span
                                    class="text-blue-600 dark:text-blue-400 font-bold text-xl"><?php echo e(number_format($finalAmount, 0, ',', '.')); ?>

                                    VNĐ</span>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-3">💳 Phương thức thanh
                        toán</label>
                    <select wire:model="paymentMethod"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                        <option value="cash">💵 Tiền mặt</option>
                        <option value="bank_transfer">🏦 Chuyển khoản</option>
                        <option value="credit_card">💳 Thẻ tín dụng</option>
                    </select>
                </div>

                
                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-3">📝 Ghi chú</label>
                    <textarea wire:model="note" rows="3" placeholder="Nhập ghi chú (tùy chọn)..."
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 resize-none"></textarea>
                </div>

                
                <button wire:click="processPayment" <?php if(count($selectedItems) == 0): ?> disabled <?php endif; ?>
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-4 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Xác nhận thanh toán
                </button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Users/smyth/Herd/icy/resources/views/livewire/back/finance/tuition/tuitions-payment.blade.php ENDPATH**/ ?>