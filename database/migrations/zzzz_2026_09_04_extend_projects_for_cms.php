<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('tag')->nullable()->after('slug');
            $table->date('start_date')->nullable()->after('location');
            $table->date('end_date')->nullable()->after('start_date');
            $table->unsignedInteger('sort_order')->default(0)->index()->after('status');
            $table->boolean('is_active')->default(true)->index()->after('sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['is_active']);
            $table->dropColumn(['slug', 'tag', 'start_date', 'end_date', 'sort_order', 'is_active']);
        });
    }
};