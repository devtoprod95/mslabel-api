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
        Schema::create('main_top_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable(false)->comment('제목');
            $table->string('name', 50)->nullable(false)->comment('users name 작성자');
            $table->text('img_url')->nullable(false)->comment('이미지 주소');
            $table->text('link')->nullable(false)->comment('이동 주소');
            $table->enum('is_show', ["Y", "N"])->default("Y")->comment('노출 여부');
            $table->timestamp('show_started_at')->nullable()->comment('노출시작일자');
            $table->timestamp('show_ended_at')->nullable()->comment('노출종료일자');

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('name')->references('name')->on('users')->onDelete('cascade');

            $table->index('title');
            $table->index('name');
            $table->index('is_show');
        });

        DB::statement('ALTER TABLE main_top_banners COMMENT "메인 상단 배너 리스트"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_top_banners');
    }
};