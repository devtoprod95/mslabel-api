<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_introductions', function (Blueprint $table) {
            $table->id();
            $table->enum('section', [1, 2])->default(1)->comment('노출 섹션');
            $table->string('category', 10)->default("brand")->comment('카테고리 종류');
            $table->text('contents')->nullable(false)->comment('내용');
            $table->text('img_url')->nullable(false)->comment('이미지 주소');
            $table->text('link')->nullable(false)->comment('이동 주소');
            $table->string('name', 50)->nullable(false)->comment('users name 작성자');
            $table->enum('is_show', ["Y", "N"])->default("Y")->comment('노출 여부');

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('name')->references('name')->on('users')->onDelete('cascade');

            $table->index('section');
            $table->index('category');
            $table->index('name');
            $table->index('is_show');
        });

        DB::statement('ALTER TABLE main_introductions COMMENT "메인 소개 리스트"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_introductions');
    }
};