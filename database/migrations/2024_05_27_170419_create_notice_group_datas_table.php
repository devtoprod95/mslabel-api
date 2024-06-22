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
        Schema::create('notice_group_datas', function (Blueprint $table) {
            $table->id();
            $table->string('title', 20)->unique()->nullable(false)->comment('제목');
            $table->unsignedSmallInteger('rank')->default(1)->nullable(false)->comment('노출 순서');

            $table->timestamps();
            $table->softDeletes();
            
            $table->index('title');
            $table->index('rank');
        });

        DB::statement('ALTER TABLE notice_group_datas COMMENT "게시판 그룹"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notice_group_datas');
    }
};