<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imei')->nullable()->default('999999999999999');
            $table->json('client')->nullable();
            $table->unsignedInteger('commercial_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('diagnostic')->nullable();
            $table->string('extra_problem')->nullable();
            $table->string('solution')->nullable();
            $table->double('charges')->default(0);
            $table->timestamp('delivered_at')->useCurrent();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->softDeletes();


            $table->foreign('commercial_id')->references('id')->on('commercials');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
