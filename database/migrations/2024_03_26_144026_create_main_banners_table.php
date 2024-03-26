<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('rank')->default(1)->nullable(false)->comment('이미지 노출 순서');
            $table->enum('is_show', ["Y", "N"])->default("Y")->nullable(false)->comment('이미지 노출 여부');
            $table->text('img_url')->nullable(false)->comment('이미지 url');
            $table->text('img_name')->nullable(false)->comment('이미지 이름');
            $table->string('mime', 20)->nullable(false)->comment('이미지 mime');

            $table->timestamps();
            $table->softDeletes();

            $table->index('rank');
            $table->index('is_show');
        });

        DB::statement('ALTER TABLE main_banners COMMENT "메인 배너 이미지 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_banners');
    }
};
