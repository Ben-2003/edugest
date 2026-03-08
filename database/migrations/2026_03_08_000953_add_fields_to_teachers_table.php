<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute email et hire_date à la table teachers
     */
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('email')->unique()->nullable()->after('last_name');
            $table->date('hire_date')->nullable()->after('specialization');
        });
    }

    /**
     * Annule les modifications
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['email', 'hire_date']);
        });
    }
};