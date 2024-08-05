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
        Schema::create('board_board_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable(false)->comment("notice_group_datas id");
            $table->unsignedBigInteger('sub_id')->nullable(false)->comment("notice_sub_datas id");
            $table->string('user_id', 50)->nullable(false)->comment('admin_datas user_id');

            $table->string('company', 25)->nullable(false)->comment('회사명');
            $table->string('title', 50)->nullable(false)->comment('제목');
            $table->enum('is_reply', ["Y", "N"])->default("N")->comment('답변 여부');
            $table->string('contact_name', 25)->nullable(false)->comment('담당자 성명');
            $table->string('contact_email', 25)->nullable(false)->comment('담당자 이메일');
            $table->string('contact_phone', 25)->nullable(false)->comment('담당자 번호');
            $table->string('password', 50)->nullable(false)->comment('비밀번호');
            $table->string('size', 50)->nullable(false)->comment('제품 규격');
            $table->string('purpose', 50)->nullable(false)->comment('제품 용도');
            $table->string('material', 50)->nullable(false)->comment('원단 및 코딩 여부');
            $table->string('shape', 50)->nullable(false)->comment('가공 형태');
            $table->string('quantity', 50)->nullable(false)->comment('수량');
            $table->text('desc')->nullable(false)->comment('기타 문의사항');
            $table->string('etc_file')->nullable(false)->comment('파일 주소');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('group_id')->references('id')->on('notice_group_datas')->onDelete('cascade');
            $table->foreign('sub_id')->references('id')->on('notice_sub_datas')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('admin_datas')->onDelete('cascade');

            $table->index('company');
            $table->index('title');
            $table->index('contact_name');
            $table->index('contact_email');
            $table->index('contact_phone');
        });

        DB::statement('ALTER TABLE board_board_datas COMMENT "게시판 유형 게시판 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_board_datas');
    }
};