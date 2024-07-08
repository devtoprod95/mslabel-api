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
        Schema::create('board_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable(false)->comment("notice_group_datas id");
            $table->unsignedBigInteger('notice_sub_id')->nullable(false)->comment("notice_sub_datas id");
            $table->string('title', 50)->nullable(false)->comment("제목");
            $table->enum('is_show', ["Y", "N"])->default("Y")->comment('노출 여부');
            $table->text('desc')->nullable(false)->comment('내용');
            $table->string('user_id', 50)->nullable(false)->comment('admin_datas user_id');
            $table->string('material', 20)->nullable(false)->comment("원단");
            $table->string('size', 20)->nullable(false)->comment("사이즈");
            $table->string('shape', 20)->nullable(false)->comment("형태");

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('group_id')->references('id')->on('notice_group_datas')->onDelete('cascade');
            $table->foreign('notice_sub_id')->references('id')->on('notice_sub_datas')->onDelete('cascade');

            $table->index('group_id');
            $table->index('notice_sub_id');
            $table->index('is_show');
            $table->index('user_id');
            $table->index('material');
            $table->index('size');
            $table->index('shape');
        });

        DB::statement('ALTER TABLE board_datas COMMENT "게시판 리스트"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_datas');
    }
};