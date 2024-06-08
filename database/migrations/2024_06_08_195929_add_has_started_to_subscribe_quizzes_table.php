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
        Schema::table('subscribe_quizzes', function (Blueprint $table) {
            $table->boolean('has_started')->default(0)
            ->after('quiz_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscribe_quizzes', function (Blueprint $table) {
            $table->dropColumn(['has_started']);
        });
    }
};
