<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_lang', function (Blueprint $table) {
            $table->id();
            $table->integer('postId')->comment('文章主檔Id');
            $table->string('postLangType', 20)->comment('文章語言別');
            $table->string('postTitle', 50)->comment('文章標題');
            $table->text('postContent')->comment('文章內容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_lang');
    }
};
