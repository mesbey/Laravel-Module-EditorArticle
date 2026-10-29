<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->index();
            $table->string('locale', 10);
            $table->string('name', 191);
            $table->string('slug', 191);
            $table->text('description')->nullable();
            $table->boolean('published')->default(false)->index();
            $table->timestamps();
            $table->unique(['locale', 'slug']);
            $table->unique(['category_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_translations');
    }
}
