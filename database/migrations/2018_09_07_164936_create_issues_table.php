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
            $table->string('imei');
            $table->json('client');
            $table->unsignedInteger('commercial_id');
            $table->unsignedInteger('user_id');
            $table->string('diagnostic')->nullable();
            $table->unsignedInteger('problem_id');
            $table->string('extra_problem')->nullable();
            $table->string('solution')->nullable();
            $table->string('status')->default(0);
            $table->double('charges')->default(0);
            $table->timestamp('delivered_at');
            $table->timestamp('received_at')->nullable();
            $table->timestamp('closed_at')->nullable();


            $table->foreign('commercial_id')->references('id')->on('commercials');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('problem_id')->references('id')->on('problems');
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
