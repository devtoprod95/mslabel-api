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
        Schema::create('notice_sub_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable(false)->comment("notice_group_datas id");
            $table->string('title', 50)->nullable(false)->comment("제목");
            $table->enum('type', ["image", "product", "board", "editor"])->default("image")->nullable(false)->comment('유형');
            $table->unsignedSmallInteger('rank')->default(1)->nullable(false)->comment("노출 순서");

            $table->foreign('group_id')->references('id')->on('notice_group_datas')->onDelete('cascade');
            $table->index("group_id");
            $table->index("type");
            $table->index("rank");

            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE notice_sub_datas COMMENT "서브 메뉴 게시판 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notice_sub_datas');
    }
};
