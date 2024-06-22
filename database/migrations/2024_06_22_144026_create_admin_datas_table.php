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
        Schema::create('admin_datas', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 50)->nullable(false)->unique();
            $table->string('email', 50)->nullable(false)->unique();
            $table->string('password');
            $table->string('user_name', 25)->nullable(false);

            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE admin_datas COMMENT "관리자 테이블"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_datas');
    }
};
