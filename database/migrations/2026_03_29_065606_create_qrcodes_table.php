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
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->id();
            $table->string('qr_name'); // ឈ្មោះ QR (ឧទាហរណ៍៖ ABA Pay, Telegram)
            $table->string('qr_image'); // ឈ្មោះ File រូបភាព
            $table->boolean('is_active')->default(true); // បើក/បិទ ការបង្ហាញ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qrcodes');
    }
};
