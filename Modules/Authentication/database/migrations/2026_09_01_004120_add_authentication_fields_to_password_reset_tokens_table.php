<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_reset_tokens_new', function (Blueprint $table) {
            $table->id();
            $table->string('resettable_type');
            $table->unsignedBigInteger('resettable_id');
            $table->string('guard');
            $table->string('email');
            $table->string('token');
            $table->timestamp('expires_at');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index(
                ['resettable_type', 'resettable_id'],
                'password_reset_tokens_resettable_index'
            );

            $table->index(
                ['email', 'guard'],
                'password_reset_tokens_email_guard_index'
            );
        });

        Schema::drop('password_reset_tokens');

        Schema::rename(
            'password_reset_tokens_new',
            'password_reset_tokens'
        );
    }

    public function down(): void
    {
        Schema::create('password_reset_tokens_old', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::drop('password_reset_tokens');

        Schema::rename(
            'password_reset_tokens_old',
            'password_reset_tokens'
        );
    }
};