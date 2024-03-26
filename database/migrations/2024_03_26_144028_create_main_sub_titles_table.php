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
        Schema::create('main_sub_titles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('title_id')->nullable(false)->comment('main_titles id');
            $table->string('sub_title_type', 20)->nullable(false)->comment('서브 타이들 분류');
            $table->string('title', 50)->nullable(false)->comment('제목');
            $table->unsignedInteger('rank')->default(1)->nullable(false)->comment('노출 순서');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('title_id')->references('id')->on('main_titles')->onDelete('cascade');
            $table->index('sub_title_type');
            $table->index('rank');
        });

        DB::statement('ALTER TABLE main_sub_titles COMMENT "메인 서브 타이틀 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_sub_titles');
    }
};
