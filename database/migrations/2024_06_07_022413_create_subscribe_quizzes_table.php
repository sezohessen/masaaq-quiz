<?php

use App\Models\Member;
use App\Models\Quiz;
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
        Schema::create('subscribe_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Member::class)
            ->constrained()
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->string('link');
            $table->foreignIdFor(Quiz::class)
            ->constrained()
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribe_quizzes');
    }
};
