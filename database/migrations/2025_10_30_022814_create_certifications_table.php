<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opportunity_id')->constrained('opportunities')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Volunteer
            $table->foreignId('organization_id')->constrained('users')->onDelete('cascade');  // Approving org (references users table)
            $table->string('title');  // e.g., "Certificate of Completion"
            $table->text('message')->nullable();
            $table->boolean('approved')->default(false);
            $table->string('pdf_path')->nullable();  // Generated PDF URL
            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'approved']);
            $table->index(['organization_id', 'approved']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};