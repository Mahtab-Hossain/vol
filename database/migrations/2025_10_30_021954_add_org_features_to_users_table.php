<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('verified')->default(false);  // Verified org badge
            $table->text('bio')->nullable();  // Org description
            $table->json('gallery')->default(json_encode([]));  // Photo URLs
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['verified', 'bio', 'gallery']);
        });
    }
};