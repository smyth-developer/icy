<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('authentication_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('email')->nullable(); // Email được sử dụng để đăng nhập
            $table->string('username')->nullable(); // Username được sử dụng để đăng nhập
            $table->enum('login_type', ['email', 'username'])->default('email'); // Loại đăng nhập
            $table->enum('status', ['success', 'failed', 'blocked', 'logout']); // Trạng thái đăng nhập
            $table->string('ip_address', 45)->nullable(); // Địa chỉ IP
            $table->text('user_agent')->nullable(); // Thông tin trình duyệt
            $table->string('device')->nullable(); // Thiết bị (mobile, desktop, tablet)
            $table->string('location')->nullable(); // Vị trí địa lý (nếu có)
            $table->string('failure_reason')->nullable(); // Lý do thất bại (wrong password, account locked, etc.)
            $table->json('additional_data')->nullable(); // Dữ liệu bổ sung (JSON)
            $table->timestamp('login_at'); // Thời gian đăng nhập
            $table->timestamp('logout_at')->nullable(); // Thời gian đăng xuất
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['user_id', 'login_at']);
            $table->index(['email', 'login_at']);
            $table->index(['ip_address', 'login_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authentication_logs');
    }
};
