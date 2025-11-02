<?php

use App\Models\EmpDetail;
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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EmpDetail::class);
            $table->foreignIdFor(EmpDetail::class, 'approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->string('status');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->text('purpose');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};
