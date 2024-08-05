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
        Schema::create('board_category_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('board_id')->nullable(false)->comment("board_board_datas id");
            $table->unsignedBigInteger('category_id')->nullable(false)->comment("board_category_datas id");

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('board_id')->references('id')->on('board_board_datas')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('board_category_datas')->onDelete('cascade');

            $table->index('board_id');
            $table->index('category_id');
        });

        DB::statement('ALTER TABLE board_category_mappings COMMENT "게시판 유형 카테고리 맵핑 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_category_mappings');
    }
};