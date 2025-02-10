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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable()->comment('上映日');
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('sheet_id')->constrained()->onDelete('cascade');
            $table->unique(['schedule_id', 'sheet_id']);
            $table->string('email', 255)->comment('予約者メールアドレス');
            $table->string('name', 255)->comment('予約者名');
            $table->boolean('is_canceled')->default(false)->comment('予約キャンセル済み');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
