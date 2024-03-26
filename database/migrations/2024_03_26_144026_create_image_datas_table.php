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
        Schema::create('image_datas', function (Blueprint $table) {
            $table->id();
            $table->string('img_type', 20)->nullable(false)->comment('이미지 분류');
            $table->text('img_url')->nullable(false)->comment('이미지 url');
            $table->text('img_name')->nullable(false)->comment('이미지 이름');
            $table->text('img_link')->nullable(false)->comment('이미지 링크');
            $table->unsignedInteger('rank')->default(1)->nullable(false)->comment('노출 순서');
            $table->string('mime', 20)->nullable(false)->comment('이미지 mime');

            $table->timestamps();
            $table->softDeletes();

            $table->index('img_type');
            $table->index('rank');
        });

        DB::statement('ALTER TABLE image_datas COMMENT "이미지 데이터 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_datas');
    }
};
