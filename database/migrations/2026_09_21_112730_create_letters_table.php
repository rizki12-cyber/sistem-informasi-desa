<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->string('request_number', 30)->unique();

            // Relasi ke jenis surat
            $table->foreignId('letter_type_id')->constrained('letter_types')->cascadeOnDelete();

            // Data pemohon
            $table->string('name', 100);
            $table->string('nik', 16);
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('religion', 30)->nullable();
            $table->string('marital_status', 30)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->text('address');
            $table->string('email', 100);
            $table->string('phone', 20)->nullable();

            // Keperluan
            $table->text('purpose');

            // Berkas pendukung (KTP, KK, dll)
            $table->json('attachments')->nullable();

            // Status
            $table->enum('status', ['pending', 'processing', 'ready', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};