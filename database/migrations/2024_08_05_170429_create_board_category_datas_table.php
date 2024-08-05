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
        Schema::create('board_category_datas', function (Blueprint $table) {
            $table->id();
            
            $table->string('title', 10)->unique()->nullable(false)->comment('카테고리 명');

            $table->timestamps();
            $table->softDeletes();

            $table->index('title');
        });

        DB::statement('ALTER TABLE board_category_datas COMMENT "게시판 유형 카테고리 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_category_datas');
    }
};