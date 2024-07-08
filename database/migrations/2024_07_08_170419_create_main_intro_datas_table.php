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
        Schema::create('main_intro_datas', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable(false)->comment('제목');
            $table->string('user_id', 50)->nullable(false)->comment('admin_datas user_id');
            $table->text('img_url')->nullable(false)->comment('이미지 주소');
            $table->text('desc')->nullable(false)->comment('내용');
            $table->enum('is_show', ["Y", "N"])->default("Y")->comment('노출 여부');

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')->references('user_id')->on('admin_datas')->onDelete('cascade');

            $table->index('title');
            $table->index('user_id');
            $table->index('is_show');
        });

        DB::statement('ALTER TABLE main_intro_datas COMMENT "메인 소개 리스트"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_intro_datas');
    }
};