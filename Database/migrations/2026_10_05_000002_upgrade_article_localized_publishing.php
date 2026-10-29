<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpgradeArticleLocalizedPublishing extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedInteger('public_author_id')->nullable()->after('author_id')->index();
        });

        Schema::table('article_contents', function (Blueprint $table) {
            $table->string('slug', 191)->nullable()->after('language_id');
            $table->text('excerpt')->nullable()->after('sub_title');
            $table->string('meta_title', 191)->nullable()->after('body');
            $table->string('meta_description', 255)->nullable()->after('meta_title');
            $table->timestamp('published_at')->nullable()->after('published');
            $table->unique(['language_id', 'slug']);
        });

        Schema::table('article_archives', function (Blueprint $table) {
            $table->string('slug', 191)->nullable()->after('language_id');
            $table->text('excerpt')->nullable()->after('sub_title');
            $table->string('meta_title', 191)->nullable()->after('body');
            $table->string('meta_description', 255)->nullable()->after('meta_title');
            $table->timestamp('published_at')->nullable()->after('published');
        });

        Schema::create('article_slug_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id')->index();
            $table->string('locale', 10);
            $table->string('slug', 191);
            $table->timestamps();
            $table->unique(['locale', 'slug']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_slug_histories');

        Schema::table('article_archives', function (Blueprint $table) {
            $table->dropColumn(['slug', 'excerpt', 'meta_title', 'meta_description', 'published_at']);
        });

        Schema::table('article_contents', function (Blueprint $table) {
            $table->dropUnique(['language_id', 'slug']);
            $table->dropColumn(['slug', 'excerpt', 'meta_title', 'meta_description', 'published_at']);
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('public_author_id');
        });
    }
}
