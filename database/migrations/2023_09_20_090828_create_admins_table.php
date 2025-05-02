<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., ANES300
            $table->string('title');
            $table->integer('level'); // Academic level (1-8)
            $table->integer('sch'); // Credit hours
            $table->integer('lecture_hours')->default(0);
            $table->integer('practical_hours')->default(0);
            $table->integer('clinical_hours')->default(0);
            $table->timestamps();
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('department_instructor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('instructor_id')->constrained();
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('location')->nullable();
            $table->timestamps();
        });

        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique(); // 1-10
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('instructor_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->foreignId('group_id')->constrained();
            $table->foreignId('period_id')->constrained();
            $table->enum('day', [
                'Sunday', 'Monday', 'Tuesday',
                'Wednesday', 'Thursday', 'Friday', 'Saturday'
            ]);
            $table->enum('type', [
                'lecture', 'lab', 'clinical',
                'practical', 'self_learning'
            ]);
            $table->timestamps();
        });

// Pivot tables for course relationships
        Schema::create('course_prerequisites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('prerequisite_id')->constrained('courses');
            $table->timestamps();
        });

        Schema::create('course_corequisites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained(); // المقرر الرئيسي
            $table->foreignId('corequisite_id')->constrained('courses'); // المقرر المتزامن
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->rememberToken();
            $table->timestamps();
        });
// Insert default admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin2024'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('instructors');
        Schema::dropIfExists('department_instructor');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('periods');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('course_prerequisites');
        Schema::dropIfExists('course_corequisites');
        Schema::dropIfExists('users');
    }
}
