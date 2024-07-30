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
        Schema::create('board_editor_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable(false)->comment("notice_group_datas id");
            $table->unsignedBigInteger('sub_id')->nullable(false)->comment("notice_sub_datas id");
            $table->string('user_id', 50)->nullable(false)->comment('admin_datas user_id');

            $table->string('title', 50)->nullable(false)->comment('제목');
            $table->text('desc')->nullable(false)->comment('내용');
            $table->enum('is_show', ["Y", "N"])->default("Y")->comment('노출 여부');
            $table->string('image')->nullable(false)->comment('이미지 주소');
            $table->date('show_started_at')->nullable(false)->comment('노출 시작일');
            $table->date('show_ended_at')->nullable(false)->comment('노출 종료일');

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('group_id')->references('id')->on('notice_group_datas')->onDelete('cascade');
            $table->foreign('sub_id')->references('id')->on('notice_sub_datas')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('admin_datas')->onDelete('cascade');

            $table->index('group_id');
            $table->index('sub_id');
            $table->index('user_id');
            $table->index('is_show');
            $table->index('title');
            $table->index('show_started_at');
            $table->index('show_ended_at');
        });

        DB::statement('ALTER TABLE board_editor_datas COMMENT "에디터 유형 게시판 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_editor_datas');
    }
};