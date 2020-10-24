<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {

            //a student need evalutate a team member with a rate and a reason
            //need a student id and his team member id
            //require a draft function

            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('team_id');
            $table->smallInteger('rate');
            $table->mediumText('description');
            $table->boolean('isSubmit')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
