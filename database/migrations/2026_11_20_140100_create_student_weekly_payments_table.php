<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_weekly_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->nullOnDelete();
            $table->unsignedSmallInteger('school_year');
            $table->unsignedTinyInteger('week_number');
            $table->decimal('amount', 12, 2)->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(
                ['student_id', 'school_year', 'week_number'],
                'student_weekly_payment_period_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_weekly_payments');
    }
};
