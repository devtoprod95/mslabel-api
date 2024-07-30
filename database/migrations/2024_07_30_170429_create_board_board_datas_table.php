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
            $table->string('contact_name', 25)->nullable(false)->comment('담당자 성명');
            $table->string('contact_email', 25)->nullable(false)->comment('담당자 이메일');
            $table->string('contact_phone', 25)->nullable(false)->comment('담당자 번호');
            $table->string('title', 50)->nullable(false)->comment('제목');
            $table->string('password', 50)->nullable(false)->comment('비밀번호');
            
            $table->enum('is_show', ["Y", "N"])->default("Y")->comment('노출 여부');
            $table->text('desc')->nullable(false)->comment('내용');
            $table->string('main_img')->nullable(false)->comment('메인 이미지 주소');
            $table->string('bottom_img1')->nullable(false)->comment('하단이미지1 주소');
            $table->string('bottom_img2')->nullable(false)->comment('하단이미지2 주소');
            $table->string('bottom_img3')->nullable(false)->comment('하단이미지3 주소');
            $table->string('bottom_img4')->nullable(false)->comment('하단이미지4 주소');
            $table->string('bottom_img5')->nullable(false)->comment('하단이미지5 주소');
            $table->string('material', 50)->nullable(false)->comment('원단');
            $table->string('size', 50)->nullable(false)->comment('사이즈');
            $table->string('shape', 50)->nullable(false)->comment('형태');
            $table->string('keywords', 50)->nullable(false)->comment('키워드');

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('group_id')->references('id')->on('notice_group_datas')->onDelete('cascade');
            $table->foreign('sub_id')->references('id')->on('notice_sub_datas')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('admin_datas')->onDelete('cascade');

            $table->index('group_id');
            $table->index('sub_id');
            $table->index('user_id');
            $table->index('is_show');
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