<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->date('payment_month');

            $table->decimal('amount', 12, 2)->default(0);

            $table->timestamps();

            $table->unique(['student_id', 'payment_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_payments');
    }
};