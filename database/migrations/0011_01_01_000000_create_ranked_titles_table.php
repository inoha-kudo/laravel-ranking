<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ranked_titles', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('ranking_id')->index();
            $table->dateTime('stored_at');
            $table->unsignedTinyInteger('rank');
            $table->string('title');
            $table->json('metadata')->nullable();
            $table->datetimes();

            $table->unique(['ranking_id', 'stored_at', 'rank']);
            $table->unique(['ranking_id', 'stored_at', 'title']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ranked_titles');
    }
};
