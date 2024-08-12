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
        Schema::create('board_reply_datas', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('board_id')->nullable(false)->comment('board_board_datas id');
            $table->string('user_id', 50)->nullable(false)->comment('admin_datas user_id');
            $table->smallInteger('reply_type')->nullable(false)->comment('답변 유형');
            $table->text('desc')->nullable(false)->comment('답변 내용');

            $table->timestamps();
            $table->softDeletes();

            $table->index('board_id');
            $table->index('user_id');
            $table->index('reply_type');
            $table->foreign('board_id')->references('id')->on('board_board_datas')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('admin_datas')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE board_reply_datas COMMENT "게시판 유형 답변 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_reply_datas');
    }
};