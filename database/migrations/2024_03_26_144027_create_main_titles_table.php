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
        Schema::create('main_titles', function (Blueprint $table) {
            $table->id();
            $table->enum('section', ["2", "3"])->nullable(false)->comment('메인 페이지 영역');
            $table->enum('type', ["text", "img"])->nullable(false)->comment('타이틀 타입');
            $table->string('title', 50)->nullable(false)->comment('제목');
            $table->text('img_url')->nullable(false)->comment('이미지 url');
            $table->text('link')->nullable(false)->comment('이동 링크');

            $table->timestamps();
            $table->softDeletes();

            $table->index('section');
            $table->index('type');
        });

        DB::statement('ALTER TABLE main_titles COMMENT "메인 타이틀 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_titles');
    }
};
