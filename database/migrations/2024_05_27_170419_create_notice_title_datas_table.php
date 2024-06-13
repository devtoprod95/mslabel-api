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
        Schema::create('notice_title_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable(false)->comment('notice_group_datas id');
            $table->string('title', 50)->nullable(false)->comment('제목');
            $table->text('link')->nullable(false)->comment('이동 주소');
            $table->unsignedSmallInteger('rank')->default(1)->nullable(false)->comment('노출 순서');

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('group_id')->references('id')->on('notice_group_datas')->onDelete('cascade');

            $table->index('group_id');
            $table->index('title');
            $table->index('rank');
        });

        DB::statement('ALTER TABLE notice_title_datas COMMENT "게시판 종류 리스트"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notice_title_datas');
    }
};