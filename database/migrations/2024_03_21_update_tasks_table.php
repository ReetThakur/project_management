<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('column_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('order')->default(0);
            $table->string('color')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['column_id']);
            $table->dropColumn(['column_id', 'order', 'color']);
        });
    }
}; 