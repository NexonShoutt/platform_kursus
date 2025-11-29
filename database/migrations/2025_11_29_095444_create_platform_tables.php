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
    // 1. Update Tabel Users (Tambah kolom role & status)
    Schema::table('users', function (Blueprint $table) {
        // Role: admin, teacher, student
        $table->string('role')->default('student')->after('email');
        $table->boolean('is_active')->default(true)->after('role');
    });

    // 2. Tabel Categories
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->timestamps();
    });

    // 3. Tabel Courses
    Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('category_id')->constrained()->cascadeOnDelete();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description');
        $table->string('thumbnail')->nullable();
        $table->date('start_date');
        $table->date('end_date');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

    // 4. Tabel Contents (Materi)
    Schema::create('contents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained()->cascadeOnDelete();
        $table->string('title');
        $table->longText('body'); // Isi materi
        $table->integer('sort_order')->default(1);
        $table->timestamps();
    });

    // 5. Tabel Enrollments (Siswa daftar kursus)
    Schema::create('course_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->timestamps();
    });

    // 6. Tabel Progress (Siswa selesai materi)
    Schema::create('content_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('content_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->timestamp('completed_at')->now();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_tables');
    }
};
