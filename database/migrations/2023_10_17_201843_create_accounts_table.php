<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('agency_id')->on('agencies');
            $table->string('name');
            $table->string('number');
            $table->string('password');
            $table->double('balance')->default(0);
            $table->timestamps();

            $table->unique(['agency_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
