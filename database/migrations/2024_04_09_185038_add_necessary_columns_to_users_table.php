<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // change name to first_name
            $table->renameColumn('name', 'first_name');

            // add new columns
            $table->string('last_name', 100);
            $table->string('phone', 20);
            $table->string('address', 255);
            $table->date('dob');
            $table->string('id_verification_file', 255);
            $table->tinyInteger('role')->comment('1: admin, 2: user');
            $table->tinyInteger('status')->comment('1: active, 2: inactive');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
