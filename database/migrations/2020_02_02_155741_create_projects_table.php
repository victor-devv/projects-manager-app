<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('owner_id');
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            // SET FOREIGN KEY CONSTRAINT
            
            //SET OWNER_ID AS A FOREIGN KEY ON THE PROJECTS TABLE, WHICH WOULD REFERENCE AN ID COLUMN ON THE UESRS TABLE

            //AFTER on('users), YOU CAN ADD ->onDelete('cascade'). SO WHEN A USER IS DELETED, ALL OF THE USER'S PROJECTS ARE DELETED

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
