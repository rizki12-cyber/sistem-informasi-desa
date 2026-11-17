<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('letter_types', function (Blueprint $table) {
            $table->json('form_schema')->nullable()->after('requirements');
        });

        Schema::table('letters', function (Blueprint $table) {
            $table->json('letter_data')->nullable()->after('purpose');
            $table->string('pdf_path')->nullable()->after('attachments');
            $table->timestamp('pdf_generated_at')->nullable()->after('pdf_path');
        });
    }

    public function down(): void
    {
        Schema::table('letter_types', function (Blueprint $table) {
            $table->dropColumn('form_schema');
        });
        Schema::table('letters', function (Blueprint $table) {
            $table->dropColumn(['letter_data', 'pdf_path', 'pdf_generated_at']);
        });
    }
};