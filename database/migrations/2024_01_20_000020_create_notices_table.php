<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('set null')->nullable();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['general', 'academic', 'event', 'urgent'])->default('general');
            $table->date('publish_date');
            $table->date('expiry_date')->nullable();
            $table->enum('visibility', ['all', 'teachers', 'students', 'guardians'])->default('all');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
