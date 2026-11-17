<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_lookup_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_input', 30);
            $table->string('email_input', 100);
            $table->string('ip_address', 45);
            $table->boolean('found')->default(false);
            $table->timestamps();

            $table->index('created_at');
            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_lookup_logs');
    }
};