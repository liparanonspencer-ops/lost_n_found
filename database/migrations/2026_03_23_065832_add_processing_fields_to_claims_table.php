<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('claims', function (Blueprint $blade) {
            // Adding the missing columns
            $blade->timestamp('processed_at')->nullable()->after('status');
            $blade->foreignId('processed_by')->nullable()->after('processed_at')->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('claims', function (Blueprint $blade) {
            $blade->dropForeign(['processed_by']);
            $blade->dropColumn(['processed_at', 'processed_by']);
        });
    }
};