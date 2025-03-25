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
        Schema::connection('games')->create('one_to_fifty_scores', function (Blueprint $table) {
            $table->id();
            
            $table->string('nickname', 100)->nullable(false)->comment('닉네임');
            $table->date('date')->nullable(false)->comment('YYYY-mm-dd 형식 날짜');
            $table->decimal('time', 6, 2)->nullable(false)->comment('기록 시간(xxx.xx)');
            
            $table->timestamps();

            $table->index('nickname');
            $table->index('date');
        });

        DB::connection('games')->statement('ALTER TABLE one_to_fifty_scores COMMENT "1to50 기록 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('games')->dropIfExists('one_to_fifty_scores');
    }
};