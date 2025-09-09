<?php

namespace App\Livewire\Back\Finance\Tuition;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use App\Support\Bank\BankHelper;
use App\Support\Tuition\TuitionHelper;
use App\Repositories\Contracts\BankRepositoryInterface;
use App\Repositories\Contracts\SeasonRepositoryInterface;
use App\Repositories\Contracts\ProgramRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Repositories\Contracts\TuitionRepositoryInterface;
use App\Repositories\Contracts\ProgramLocationPriceRepositoryInterface;

#[Title('Thanh toán học phí')]
class TuitionsPayment extends Component
{
    // Search
    public $searchProgram = '';
    public $programs = [];
    public $filteredPrograms = [];
    
    // Student selection
    public $selectedStudent = null;
    public $students = [];
    public $searchStudent = '';
    public $filteredStudents = [];
    
    // Seasons
    public $seasons = [];
    
    // Banks
    public $banks = [];
    public $selectedBankId = null;
    
    // Transaction History
    public $transactionHistory = [];
    
    // Selected items
    public $selectedItems = [];
    
    // Payment
    public $totalAmount = 0;
    public $discountAmount = 0;
    public $discountType = 'vnd'; // 'vnd' or 'percent'
    public $finalAmount = 0;
    public $note = '';
    public $paymentMethod = 'cash';

    public function mount()
    {
        $this->loadPrograms();
        $this->loadStudents();
        $this->loadSeasons();
        $this->loadBanks();
    }

    #[On('turnOnBankTransfer')]
    public function turnOnBankTransfer()
    {
        $this->dispatch('turnOnBankTransfer');
    }

    public function loadPrograms()
    {
        $programs = app(ProgramRepositoryInterface::class)->getAllPrograms();
        $this->programs = [];
        
        // Chuyển đổi và thêm giá mặc định (sẽ được override khi chọn học sinh)
        foreach ($programs as $program) {
            $this->programs[] = [
                'id' => $program->id,
                'name' => $program->name,
                'english_name' => $program->english_name,
                'price' => 0, // Giá mặc định, sẽ được cập nhật khi chọn học sinh
            ];
        }
        
        $this->filteredPrograms = []; // Không hiển thị gì ban đầu
    }

    public function loadStudents()
    {
        $this->students = app(StudentRepositoryInterface::class)->getStudentsOfLocationWithFilters()->toArray();
        $this->filteredStudents = $this->students; // Hiển thị tất cả học sinh ban đầu
    }

    public function loadSeasons()
    {
        $this->seasons = app(SeasonRepositoryInterface::class)->getSeasonAvailable()->toArray();
    }

    public function loadBanks()
    {
        $this->banks = app(BankRepositoryInterface::class)->getActiveBanks()->toArray();
    }

    public function loadTransactionHistory($studentId)
    {
        $this->transactionHistory = app(TuitionRepositoryInterface::class)->getTuitionsByUserId($studentId)->toArray();
    }

    public function getProgramPriceForStudent($programId, $studentId)
    {
        try {
            // Lấy location_id từ bảng pivot location_user
            $locationUser = \Illuminate\Support\Facades\DB::table('location_user')
                ->where('user_id', $studentId)
                ->first();
            
            if (!$locationUser || !$locationUser->location_id) {
                return 0;
            }
            
            // Lấy giá từ ProgramLocationPrice
            $programLocationPrice = app(ProgramLocationPriceRepositoryInterface::class)
                ->getPriceByProgramAndLocation($programId, $locationUser->location_id);
            
            if ($programLocationPrice) {
                return (float) $programLocationPrice->price;
            }
            
            // Nếu không tìm thấy giá theo location, trả về 0
            return 0;
            
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function updatedSearchProgram()
    {
        if (empty($this->searchProgram)) {
            $this->filteredPrograms = $this->programs; // Hiển thị tất cả chương trình khi chưa tìm kiếm
        } else {
            $this->filteredPrograms = array_filter($this->programs, function($program) {
                return stripos($program['name'], $this->searchProgram) !== false ||
                       stripos($program['english_name'], $this->searchProgram) !== false;
            });
        }
    }

    public function onProgramSearchFocus()
    {
        // Chỉ hiển thị danh sách chương trình khi đã chọn học sinh
        if ($this->selectedStudent) {
            $this->filteredPrograms = $this->programs;
        }
    }

    public function onProgramSearchBlur()
    {
        // Khi blur khỏi ô tìm kiếm, giữ danh sách hiển thị nếu đã chọn học sinh
        if ($this->selectedStudent) {
            $this->filteredPrograms = $this->programs;
        }
    }

    public function updatedSearchStudent()
    {
        if (empty($this->searchStudent)) {
            $this->filteredStudents = $this->students; // Hiển thị tất cả học sinh khi chưa tìm kiếm
        } else {
            $this->filteredStudents = array_filter($this->students, function($student) {
                return stripos($student['name'], $this->searchStudent) !== false || 
                       stripos($student['account_code'], $this->searchStudent) !== false;
            });
        }
    }

    public function paymentMethodChanged()
    {
        // Method để Livewire tự động detect changes
    }

    public function selectedBankChanged()
    {
        // Method để Livewire tự động detect changes
    }

    public function mainMenuQRCode()
    {
        $this->dispatch('mainMenuQRCode');
    }

    public function turnOffQRCode()
    {
        $this->dispatch('turnOffQRCode');
    }

    public function selectStudent($studentId)
    {
        $student = collect($this->students)->firstWhere('id', $studentId);
        if ($student) {
            // Lấy thông tin đầy đủ của học sinh từ database
            $fullStudent = app(StudentRepositoryInterface::class)->getStudentById($studentId);
            if ($fullStudent) {
                // Lấy location_id từ bảng pivot
                $locationUser = \Illuminate\Support\Facades\DB::table('location_user')
                    ->where('user_id', $studentId)
                    ->first();
                $locationId = $locationUser ? $locationUser->location_id : null;
                
                $this->selectedStudent = [
                    'id' => $fullStudent->id,
                    'name' => $fullStudent->name,
                    'account_code' => $fullStudent->account_code,
                    'location_id' => $locationId,
                ];
            } else {
                $this->selectedStudent = $student;
            }
            
            $this->searchStudent = ''; // Xóa từ khóa tìm kiếm sau khi chọn
            $this->filteredStudents = []; // Xóa danh sách kết quả
            // Load lịch sử giao dịch của học sinh
            $this->loadTransactionHistory($studentId);
        }
    }

    public function clearStudentSelection()
    {
        $this->selectedStudent = null;
        $this->transactionHistory = []; // Xóa lịch sử giao dịch
        $this->loadStudents();
    }

    public function addProgram($programId)
    {
        if (!$this->selectedStudent) {
            session()->flash('error', 'Vui lòng chọn học sinh trước khi thêm chương trình!');
            return;
        }

        $program = collect($this->programs)->firstWhere('id', $programId);
        if ($program) {
            // Lấy giá từ ProgramLocationPrice dựa trên location của học sinh
            $price = $this->getProgramPriceForStudent($programId, $this->selectedStudent['id']);
            
            if ($price <= 0) {
                session()->flash('error', 'Chương trình này chưa có giá cho cơ sở của học sinh!');
                return;
            }
            
            $newItem = [
                'id' => (int) $program['id'],
                'name' => $program['name'],
                'price' => (float) $price,
                'season_id' => null, // Sẽ được chọn sau
                'season_name' => null,
                'type' => 'program'
            ];
            
            $this->selectedItems[] = $newItem;
            
            // Giữ danh sách chương trình hiển thị sau khi thêm
            $this->filteredPrograms = $this->programs;
            
            $this->calculateTotal();
            
            // Force refresh component
            $this->dispatch('$refresh');
            
        }
    }

    public function addUniform()
    {
        $this->selectedItems[] = [
            'id' => 'uniform',
            'name' => 'Đồng phục',
            'price' => 100000,
            'season_id' => null,
            'season_name' => null,
            'type' => 'uniform'
        ];
        
        $this->calculateTotal();
    }

    public function removeItem($index)
    {
        if (isset($this->selectedItems[$index])) {
            unset($this->selectedItems[$index]);
            $this->selectedItems = array_values($this->selectedItems);
            $this->calculateTotal();
        }
    }

    public function selectSeason($index, $seasonId)
    {
        if (isset($this->selectedItems[$index])) {
            $season = collect($this->seasons)->firstWhere('id', $seasonId);
            if ($season) {
                $this->selectedItems[$index]['season_id'] = $season['id'];
                $this->selectedItems[$index]['season_name'] = $season['name'];
            }
            $this->calculateTotal();
        }
    }

    public function updateItemDiscount($index, $discountAmount)
    {
        if (isset($this->selectedItems[$index])) {
            $this->selectedItems[$index]['discount_amount'] = (float) $discountAmount;
            $this->calculateTotal();
        }
    }

    public function updateItemDiscountType($index, $discountType)
    {
        if (isset($this->selectedItems[$index])) {
            $this->selectedItems[$index]['discount_type'] = $discountType;
            // Reset discount amount when changing type
            $this->selectedItems[$index]['discount_amount'] = 0;
            $this->calculateTotal();
        }
    }

    public function selectBank($bankId)
    {
        $this->selectedBankId = $bankId;
    }


    public function calculateTotal()
    {
        $this->totalAmount = 0;
        $totalItemDiscounts = 0;

        foreach ($this->selectedItems as $item) {
            $itemPrice = (float) $item['price'];
            
            // Tính giảm giá cho từng item
            if (isset($item['discount_amount']) && $item['discount_amount'] > 0) {
                $discountAmount = (float) $item['discount_amount'];
                if (($item['discount_type'] ?? 'vnd') === 'percent') {
                    $itemDiscount = ($itemPrice * $discountAmount) / 100;
                } else {
                    $itemDiscount = $discountAmount;
                }
                $totalItemDiscounts += $itemDiscount;
            }
            
            $this->totalAmount += $itemPrice;
        }

        // Tính giảm giá tổng (nếu có)
        $totalDiscount = $totalItemDiscounts;
        if ($this->discountAmount > 0) {
            $discountAmount = (float) $this->discountAmount;
            if ($this->discountType === 'percent') {
                $totalDiscount += ($this->totalAmount * $discountAmount / 100);
            } else {
                $totalDiscount += $discountAmount;
            }
        }

        $this->finalAmount = $this->totalAmount - $totalDiscount;
        
        // Đảm bảo finalAmount không âm
        if ($this->finalAmount < 0) {
            $this->finalAmount = 0;
        }
    }

    public function updatedDiscountAmount()
    {
        $this->calculateTotal();
    }

    public function updatedDiscountType()
    {
        // Reset discount amount khi thay đổi loại giảm giá
        $this->discountAmount = 0;
        $this->calculateTotal();
    }


    public function updatedNote()
    {
        // Method để Livewire tự động detect changes
    }

    public function processPayment()
    {
        // Kiểm tra xem đã chọn học sinh chưa
        if (!$this->selectedStudent) {
            session()->flash('error', 'Vui lòng chọn học sinh trước khi thanh toán');
            return;
        }

        // Kiểm tra xem có chương trình nào được chọn không
        if (count($this->selectedItems) == 0) {
            session()->flash('error', 'Vui lòng chọn ít nhất một chương trình');
            return;
        }

        // Kiểm tra xem tất cả chương trình đã chọn season chưa (trừ đồng phục)
        foreach ($this->selectedItems as $item) {
            if ($item['type'] !== 'uniform' && !$item['season_id']) {
                session()->flash('error', 'Vui lòng chọn season cho tất cả chương trình!');
                return;
            }
        }

        // Kiểm tra bank selection nếu payment method là bank_transfer
        if ($this->paymentMethod === 'bank_transfer' && !$this->selectedBankId) {
            session()->flash('error', 'Vui lòng chọn tài khoản ngân hàng!');
            return;
        }

        // Kiểm tra finalAmount
        if ($this->finalAmount <= 0) {
            session()->flash('error', 'Số tiền thanh toán phải lớn hơn 0!');
            return;
        }

        try {
            $student = app(StudentRepositoryInterface::class)->getStudentById($this->selectedStudent['id']);
            
            if (!$student) {
                session()->flash('error', 'Không tìm thấy thông tin học sinh!');
                return;
            }
            
            $createdTuitions = [];
            $baseReceiptNumber = 'ICY' . $student->username . uniqid();
            
            // Tạo từng bản ghi tuition cho mỗi chương trình
            foreach ($this->selectedItems as $index => $item) {
                // Tính giá cho từng item (bao gồm giảm giá item-level)
                $itemPrice = (float) $item['price'];
                $itemDiscount = 0;
                
                if (isset($item['discount_amount']) && $item['discount_amount'] > 0) {
                    $discountAmount = (float) $item['discount_amount'];
                    if (($item['discount_type'] ?? 'vnd') === 'percent') {
                        $itemDiscount = ($itemPrice * $discountAmount) / 100;
                    } else {
                        $itemDiscount = $discountAmount;
                    }
                }

                if ($this->paymentMethod === 'bank_transfer') {
                    if ($item['type'] === 'uniform') {
                        $note = "Uniform - " . $student->username;
                    } else {
                        $note = BankHelper::generateDescriptionTransactionBankTransfer($student->id, $item['season_id'], $item['id']);
                    }
                } else {
                    $note = $this->note;
                }
                
                $finalItemPrice = $itemPrice - $itemDiscount;
                if ($finalItemPrice < 0) $finalItemPrice = 0;
                
                $tuition = [
                    'user_id' => $student->id,
                    'receipt_number' => $baseReceiptNumber . '-' . ($index + 1), // Thêm số thứ tự
                    'program_id' => $item['type'] === 'uniform' ? null : $item['id'],
                    'season_id' => $item['type'] === 'uniform' ? null : $item['season_id'],
                    'price' => $finalItemPrice,
                    'status' => 'pending',
                    'payment_method' => $this->paymentMethod,
                    'bank_id' => $this->selectedBankId,
                    'note' => $note,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $createdTuition = app(TuitionRepositoryInterface::class)->create($tuition);
                $createdTuitions[] = $createdTuition;
            }
            
            $count = count($createdTuitions);
            session()->flash('success', "Tạo thành công {$count} bản ghi thanh toán.");
            $this->redirect(route('admin.finance.tuitions-payment'));
            
        } catch (\Exception $e) {
            session()->flash('error', 'Có lỗi xảy ra khi tạo thanh toán: ' . $e->getMessage());
        }
    }

    public function showQrCode($transactionId)
    {
        $transaction = app(TuitionRepositoryInterface::class)->getTuitionById($transactionId);
        $crc16 = TuitionHelper::generateInformationTransaction($transaction);
        $bankName = app(BankRepositoryInterface::class)->getById($transaction->bank_id)->bank_name;
        $accountNumber = app(BankRepositoryInterface::class)->getById($transaction->bank_id)->account_number;
        $amount = (string) $transaction->price;

        $this->dispatch('process-payment', $crc16, $bankName, $accountNumber, $amount);
    }

    public function render()
    {
        return view('livewire.back.finance.tuition.tuitions-payment');
    }
}