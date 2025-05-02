<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            // Pastikan is_done boolean dan default-nya false
            $table->boolean('is_done')->default(false)->change();
        });
    }

    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            // Kembalikan ke kondisi sebelumnya (optional)
            $table->boolean('is_done')->change(); // tanpa default
        });
    }
};

