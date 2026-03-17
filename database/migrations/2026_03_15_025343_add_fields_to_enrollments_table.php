<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToEnrollmentsTable extends Migration
{
    public function up()
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->string('status')->default('actif')->after('enrollment_date');
            $table->string('tutor_name')->nullable()->after('status');
            $table->string('tutor_relation')->nullable()->after('tutor_name');
            $table->string('tutor_phone')->nullable()->after('tutor_relation');
            $table->string('tutor_email')->nullable()->after('tutor_phone');
            $table->string('blood_group')->nullable()->after('tutor_email');
            $table->string('medical_notes')->nullable()->after('blood_group');
            $table->text('observations')->nullable()->after('medical_notes');
        });
    }

    public function down()
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn([
                'status', 'tutor_name', 'tutor_relation',
                'tutor_phone', 'tutor_email', 'blood_group',
                'medical_notes', 'observations'
            ]);
        });
    }
}