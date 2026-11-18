<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('lastname');
            $table->string('phone');
            $table->boolean('agreed')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index('agreed');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
