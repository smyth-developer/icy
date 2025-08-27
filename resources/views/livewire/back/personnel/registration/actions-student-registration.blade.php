<div>
    {{-- Create and Update Student Modal --}}
    <flux:modal :dismissible="false" name="modal-student" class="min-w-[50rem] max-h-[90vh] overflow-y-auto">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
            <flux:heading class="font-bold text-gray-800 dark:text-gray-200 text-xl">
                {{ $isEditStudentMode ? '✏️ Cập nhật học viên' : '➕ Thêm mới học viên' }}
            </flux:heading>
            <flux:text class="mt-1 text-gray-600 dark:text-gray-400">
                {{ $isEditStudentMode ? 'Chỉnh sửa thông tin học viên trong hệ thống' : 'Thêm mới học viên vào hệ thống quản lý' }}
            </flux:text>
        </div>

        <form wire:submit.prevent='{{ $isEditStudentMode ? 'updateStudent' : 'createStudent' }}'
            class="px-8 py-6 space-y-8">
            @if ($isEditStudentMode)
                <input type="hidden" wire:model='studentId' />
            @endif

            {{-- Avatar Upload Section --}}
            <div
                class="flex flex-col items-center space-y-6 py-6 bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl border border-gray-200 dark:border-gray-600">

                {{-- Vòng tròn avatar --}}
                <div class="relative group w-32 h-32 transition-all duration-500 ease-in-out" id="avatarContainer">
                    {{-- Preview avatar chính --}}
                    <img id="avatarPreview"
                        src="{{ $avatarFile ? $avatarFile->temporaryUrl() : ($avatar && str_starts_with($avatar, 'data:image') ? $avatar : ($avatar ? asset('storage/images/avatars/' . $avatar) : asset('storage/images/avatars/default-avatar.png'))) }}"
                        alt="Avatar"
                        class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-2xl ring-4 transition-all duration-500 ease-in-out
            {{ $avatarFile ? 'ring-blue-500/30' : ($avatar && str_starts_with($avatar, 'data:image') ? 'ring-green-500/30' : ($avatar ? 'ring-purple-500/30' : 'ring-gray-300/30')) }}">

                    {{-- Nút mở webcam (overlay góc phải) - chỉ hiện khi có webcam --}}
                    @if ($hasWebcam)
                        <button type="button" id="openWebcam"
                            class="absolute bottom-0 right-0 bg-blue-500 text-white p-2 rounded-full shadow-lg hover:bg-blue-600 transition-all duration-300">
                            📸
                        </button>
                    @endif

                    {{-- Webcam overlay --}}
                    <div id="webcamOverlay"
                        class="absolute inset-0 hidden bg-black/80 rounded-full flex flex-col items-center justify-center z-10 transition-all duration-500 ease-in-out">
                        <video id="video" autoplay
                            class="w-32 h-32 object-cover rounded-full transition-all duration-500 ease-in-out"></video>
                    </div>
                </div>

                {{-- Webcam Controls - Ẩn mặc định, hiện khi webcam active --}}
                <div id="webcamControls" class="hidden space-y-3 transition-all duration-500 ease-in-out">
                    <div class="flex space-x-3">
                        {{-- Nút chụp --}}
                        <button type="button" id="capture"
                            class="bg-green-500 text-white px-6 py-2 rounded-full shadow-lg hover:bg-green-600 transition-all duration-300 font-medium">
                            📸 Chụp ảnh
                        </button>

                        {{-- Nút đóng webcam --}}
                        <button type="button" id="closeWebcam"
                            class="bg-red-500 text-white px-6 py-2 rounded-full shadow-lg hover:bg-red-600 transition-all duration-300 font-medium">
                            ❌ Đóng webcam
                        </button>
                    </div>
                </div>

                {{-- Upload file --}}
                <div class="w-full max-w-sm">
                    <flux:input type="file" wire:model="avatarFile" accept="image/*" label="📁 Chọn ảnh từ máy tính"
                        class="w-full rounded-xl border-2 border-dashed border-blue-300 hover:border-blue-500 transition-colors duration-300 bg-white/50" />
                </div>

                @error('avatarFile')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Personal Information --}}

            <div class="mb-6 text-center">
                <flux:heading size="md" class="text-gray-800 dark:text-gray-200 font-semibold">
                    Thông tin cá nhân
                </flux:heading>
            </div>

            @if (auth()->user()->locations()->count() > 1)
                <div class="space-y-6">
                    <div class="form-group">
                        <flux:select wire:model='location_id' label="🏢 Cơ sở" placeholder="Chọn cơ sở"
                            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-all duration-300">
                            <flux:select.option :value='null' label="Không chọn cơ sở" />
                            @foreach (auth()->user()->locations as $location)
                                <flux:select.option :value="$location->id" label="{{ $location->name }}" />
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            @endif

            <div class="space-y-6">
                {{-- Name and Username --}}
                <div class="grid grid-cols-5 gap-4">
                    <div class="col-span-3 form-group">
                        <flux:input wire:model='name' label="👨‍🎓 Họ và tên" placeholder="Nhập họ và tên đầy đủ"
                            wire:change='updateUsername'
                            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-all duration-300" />
                    </div>
                    <div class="col-span-2 form-group">
                        <flux:input wire:model='username' label="🔑 Tên đăng nhập" placeholder="username" disabled
                            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-all duration-300" />
                    </div>
                </div>

                {{-- Email and Account Code --}}
                <div class="grid grid-cols-5 gap-4">
                    <div class="col-span-3 form-group">
                        <flux:input type="email" wire:model='email' label="📧 Email" placeholder="example@email.com"
                            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-all duration-300" />
                    </div>

                    <div class="col-span-2 form-group">
                        <flux:input wire:model='id_card' label="🏷️ CCCD/CMND" placeholder="Nhập số CCCD/CMND"
                            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-all duration-300" />
                    </div>

                </div>



                {{-- Password fields --}}
                <div
                    class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-4 border border-yellow-200 dark:border-gray-600">
                    <div class="flex items-center mb-3">
                        <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                            {{ $isEditStudentMode ? 'Thay đổi mật khẩu (tùy chọn)' : 'Thiết lập mật khẩu' }}
                        </span>
                    </div>


                    <div class="form-group">
                        <flux:input type="password" icon="key" wire:model='password' value="{{ $password }}"
                            readonly viewable copyable />
                    </div>

                </div>


                {{-- Phone and Birthday --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <flux:input type="tel" wire:model='phone' label="📱 Số điện thoại" placeholder="0123456789"
                            class="rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 transition-all duration-300" />
                    </div>
                    <div class="form-group">
                        <flux:input type="date" wire:model='birthday' label="🎂 Ngày sinh"
                            max="{{ now()->format('Y-m-d') }}"
                            class="rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition-all duration-300" />
                    </div>
                </div>

                {{-- Address --}}
                <div class="form-group">
                    <flux:input wire:model='address' label="🏠 Địa chỉ" placeholder="Nhập địa chỉ chi tiết"
                        class="rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300" />
                </div>
            </div>


            {{-- Action Buttons --}}
            <div class="flex justify-end items-center pt-6 border-t border-gray-200 dark:border-gray-700">

                <div class="flex space-x-3">
                    <flux:modal.close>
                        <flux:button variant="ghost"
                            class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-50 transition-all duration-300">
                            ❌ Hủy
                        </flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="primary"
                        class="cursor-pointer px-8 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        {{ $isEditStudentMode ? '✅ Cập nhật' : '➕ Thêm mới' }}
                    </flux:button>
                </div>
            </div>
        </form>

    </flux:modal>

    {{-- Delete Student Modal --}}
    <flux:modal name="delete-student" class="md:w-[500px]">
        <div
            class="bg-gradient-to-br from-red-50 via-white to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-2xl">
            <!-- Header với gradient background -->
            <div class="relative px-8 py-6 bg-gradient-to-r from-red-500 via-pink-500 to-red-600 rounded-t-2xl">
                <div class="absolute inset-0 bg-black/10 rounded-t-2xl"></div>
                <div class="relative flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd">
                            </path>
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <flux:heading class="font-bold text-white text-xl">
                            🗑️ Xác nhận xóa học viên
                        </flux:heading>
                        <flux:text class="mt-1 text-red-100">
                            Hành động này không thể hoàn tác
                        </flux:text>
                    </div>
                </div>
            </div>

            <form wire:submit='deleteStudentConfirm' class="px-8 py-6 space-y-6">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-red-800 dark:text-red-200">
                                Cảnh báo xóa dữ liệu
                            </h3>
                            <div class="mt-2 text-red-700 dark:text-red-300">
                                <p class="mb-2">Bạn có chắc chắn muốn xóa học viên này không?</p>
                                <ul class="list-disc list-inside space-y-1 text-sm">
                                    <li>Tất cả thông tin học viên sẽ bị xóa vĩnh viễn</li>
                                    <li>Ảnh đại diện sẽ bị xóa khỏi hệ thống</li>
                                    <li>Hành động này không thể hoàn tác</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <flux:modal.close>
                        <flux:button variant="ghost"
                            class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-50 transition-all duration-300">
                            ↩️ Hủy bỏ
                        </flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="danger"
                        class="cursor-pointer px-8 py-2 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        🗑️ Xóa vĩnh viễn
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>

@push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const video = document.getElementById('video');
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const avatarPreview = document.getElementById('avatarPreview');
            const webcamOverlay = document.getElementById('webcamOverlay');
            const captureBtn = document.getElementById('capture');
            const webcamControls = document.getElementById('webcamControls');
            let stream;

            // Function to attach/re-attach the webcam button listener
            function attachWebcamButtonListener() {
                const openBtn = document.getElementById('openWebcam');
                if (openBtn) {
                    // Remove existing listener to prevent duplicates
                    openBtn.removeEventListener('click', openBtn._webcamListenerAttached);

                    // Create new listener
                    const listener = async () => {
                        // Issue 1: Hide the button when clicked
                        openBtn.style.display = 'none';

                        try {
                            stream = await navigator.mediaDevices.getUserMedia({
                                video: true
                            });
                            video.srcObject = stream;
                            webcamOverlay.classList.remove('hidden');
                            webcamControls.classList.remove('hidden'); // Show controls

                            // Expand the avatar container and preview
                            const avatarContainer = document.getElementById('avatarContainer');
                            const avatarPreview = document.getElementById('avatarPreview');
                            const videoElement = document.getElementById('video');

                            if (avatarContainer && avatarPreview && videoElement) {
                                // Expand to larger size
                                avatarContainer.classList.remove('w-32', 'h-32');
                                avatarContainer.classList.add('w-64', 'h-64');

                                avatarPreview.classList.remove('w-32', 'h-32');
                                avatarPreview.classList.add('w-64', 'h-64');

                                videoElement.classList.remove('w-32', 'h-32');
                                videoElement.classList.add('w-64', 'h-64');
                            }

                        } catch (error) {
                            console.log('Không thể truy cập webcam:', error);
                            alert('Không thể truy cập webcam. Vui lòng kiểm tra quyền truy cập.');
                            // Show button again if webcam access fails
                            openBtn.style.display = 'block';
                        }
                    };

                    openBtn.addEventListener('click', listener);
                    openBtn._webcamListenerAttached = listener; // Store reference for removal
                }
            }

            // Function to reset avatar size to original
            function resetAvatarSize() {
                const avatarContainer = document.getElementById('avatarContainer');
                const avatarPreview = document.getElementById('avatarPreview');
                const videoElement = document.getElementById('video');

                if (avatarContainer && avatarPreview && videoElement) {
                    // Reset to original size
                    avatarContainer.classList.remove('w-64', 'h-64');
                    avatarContainer.classList.add('w-32', 'h-32');

                    avatarPreview.classList.remove('w-64', 'h-64');
                    avatarPreview.classList.add('w-32', 'h-32');

                    videoElement.classList.remove('w-64', 'h-64');
                    videoElement.classList.add('w-32', 'h-32');
                }
            }

            // Helper function to find Livewire component
            function findLivewireComponent() {
                // Tìm component cha (students-registration) chứa wire:id
                let element = document.querySelector('[wire\\:id]');
                if (!element) {
                    // Nếu không tìm thấy, tìm element cha gần nhất có wire:id
                    element = document.closest('[wire\\:id]') || document.querySelector('[wire\\:id]');
                }

                if (element) {
                    const wireId = element.getAttribute('wire\\:id');
                    console.log('🔍 Found Livewire component with ID:', wireId);
                    return Livewire.find(wireId);
                }

                console.log('🔍 No Livewire component found');
                return null;
            }

            // Kiểm tra webcam availability
            async function checkWebcamAvailability() {
                console.log('🔍 Starting webcam availability check...');
                try {
                    const devices = await navigator.mediaDevices.enumerateDevices();
                    const videoDevices = devices.filter(device => device.kind === 'videoinput');
                    console.log('🔍 Found video devices:', videoDevices.length);

                    if (videoDevices.length > 0) {
                        // Có webcam, cập nhật Livewire component
                        console.log('🔍 Webcam found, setting hasWebcam = true');
                        // Sử dụng helper function để tìm component
                        const livewireComponent = findLivewireComponent();
                        if (livewireComponent) {
                            livewireComponent.set('hasWebcam', true);
                        }
                    } else {
                        // Không có webcam, cập nhật Livewire component
                        console.log('🔍 No webcam found, setting hasWebcam = false');
                        const livewireComponent = findLivewireComponent();
                        if (livewireComponent) {
                            livewireComponent.set('hasWebcam', false);
                        }
                    }
                } catch (error) {
                    console.log('🔍 Error checking webcam:', error);
                    const livewireComponent = findLivewireComponent();
                    if (livewireComponent) {
                        livewireComponent.set('hasWebcam', false);
                    }
                }
            }

            // Lắng nghe sự kiện kiểm tra webcam từ Livewire
            Livewire.on('check-webcam-status', async () => {
                console.log('🔍 Livewire event: check-webcam-status triggered');
                await checkWebcamAvailability();
                console.log('🔍 Webcam availability check completed');
                // After checking webcam and Livewire updates the DOM, re-attach the listener
                setTimeout(() => {
                    console.log('🔍 Attaching webcam button listener...');
                    attachWebcamButtonListener();
                    // Debug: Check if button exists after attachment
                    const openBtn = document.getElementById('openWebcam');
                    console.log('🔍 Webcam button found:', openBtn ? 'YES' : 'NO');
                    if (openBtn) {
                        console.log('🔍 Button display style:', openBtn.style.display);
                        console.log('🔍 Button classes:', openBtn.className);
                    }
                }, 200); // Increased delay to ensure DOM is fully updated
            });

            // Kiểm tra webcam khi trang load
            checkWebcamAvailability();
            // Attach initial listener
            attachWebcamButtonListener();

            // Bật webcam
            // (Event listener is now handled by attachWebcamButtonListener)

            // Chụp ảnh
            captureBtn?.addEventListener('click', () => {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                ctx.drawImage(video, 0, 0);
                const data = canvas.toDataURL('image/png');

                // Thay preview ngay
                avatarPreview.src = data;

                // Gửi về Livewire
                const livewireComponent = findLivewireComponent();
                if (livewireComponent) {
                    livewireComponent.set('avatar', data);
                }

                // Tắt webcam
                stream.getTracks().forEach(track => track.stop());
                webcamOverlay.classList.add('hidden');
                webcamControls.classList.add('hidden'); // Hide controls after capture

                // Reset avatar size to original
                resetAvatarSize();

                // Show the webcam button again after capture
                const openBtn = document.getElementById('openWebcam');
                if (openBtn) {
                    const livewireComponent = findLivewireComponent();
                    if (livewireComponent && livewireComponent.get('hasWebcam')) {
                        openBtn.style.display = 'block';
                    }
                }
            });

            // Add close webcam functionality
            const closeWebcamBtn = document.getElementById('closeWebcam');
            if (closeWebcamBtn) {
                closeWebcamBtn.addEventListener('click', () => {
                    webcamOverlay.classList.add('hidden');
                    webcamControls.classList.add('hidden'); // Hide controls when closing webcam
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                    }

                    // Reset avatar size to original
                    resetAvatarSize();

                    // Show the webcam button again
                    const openBtn = document.getElementById('openWebcam');
                    if (openBtn) {
                        const livewireComponent = findLivewireComponent();
                        if (livewireComponent && livewireComponent.get('hasWebcam')) {
                            openBtn.style.display = 'block';
                        }
                    }
                });
            }
        });
        Livewire.on('reloadPage', () => {
            location.reload();
        });
    </script>
@endpush
