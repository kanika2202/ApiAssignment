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
        Schema::create('telegram_logs', function (Blueprint $table) {
            $table->id();
            $table->string('order_id'); // សម្រាប់សម្គាល់ថាជា Order មួយណា
        $table->text('message');    // ខ្លឹមសារសារដែលបានផ្ញើ
        $table->string('status');    // ស្ថានភាព (Success ឬ Failed)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_logs');
    }
};
