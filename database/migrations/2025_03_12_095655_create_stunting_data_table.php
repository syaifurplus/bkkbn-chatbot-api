<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('stunting_data', function (Blueprint $table) {
            $table->id();
            $table->string('province');
            $table->string('district')->nullable();
            $table->year('year');
            $table->decimal('stunting_rate', 5, 2);
            $table->decimal('target_rate', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('stunting_data');
    }
};
