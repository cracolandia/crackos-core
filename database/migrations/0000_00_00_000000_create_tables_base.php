<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTablesBase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        
        \DB::beginTransaction();

        Schema::create('users', function(Blueprint $table){
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->string('reset_password_token');
            $table->string('confirmation_token');
            $table->string('confirmated_at');

            $table->timestamps();
        });

        Schema::create('firms_types', function(Blueprint $table){
            $table->increments('id');
            $table->text('description');
        });

        Schema::create('locations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('city');
            $table->string('address');
            $table->text('description');
        });

        Schema::create('firms', function(Blueprint $table){
            $table->increments('id');
            $table->integer('firm_type_id');
            $table->integer('location_id');
            $table->integer('user_id');

            $table->text('description');
            $table->string('logo');

            $table->foreign('firm_type_id')->references('id')->on('firms_types');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('coworkers', function(Blueprint $table){
            $table->increments('id');
            $table->integer('firm_id');
            $table->integer('user_id');

            $table->foreign('firm_id')->references('id')->on('firms');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('departments', function(Blueprint $table){
            $table->increments('id');
            $table->integer('firm_id');

            $table->string('title');

            $table->foreign('firm_id')->references('id')->on('firms');
        });

        Schema::create('coworkers_departments', function(Blueprint $table){
            $table->increments('id');
            $table->integer('coworker_id');
            $table->integer('department_id');
            
            $table->foreign('coworker_id')->references('id')->on('coworkers');
        });

        Schema::create('statuses', function(Blueprint $table){
            $table->increments('id');
            $table->integer('firm_id');
            $table->text('description');
            
            $table->foreign('firm_id')->references('id')->on('firms');
        });

        Schema::create('statuses_departments', function(Blueprint $table){
            $table->increments('id');
            $table->integer('department_id');
            $table->integer('status_id');

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('status_id')->references('id')->on('statuses');
        });

        Schema::create('services', function(Blueprint $table){
            $table->increments('id');
            $table->integer('firm_id');

            $table->text('description');
            $table->string('title');

            $table->foreign('firm_id')->references('id')->on('firms');
        });

        Schema::create('requests', function(Blueprint $table){
            $table->increments('id');
            $table->integer('department_id');
            $table->integer('firm_id');
            $table->integer('service_id');
            $table->integer('status_id');
            $table->integer('user_id');

            $table->text('description');
            
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('firm_id')->references('id')->on('firms');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('user_id')->references('id')->on('users');
        });

        \DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        \DB::beginTransaction();

        Schema::dropIfExists('requests');
        Schema::dropIfExists('services');
        Schema::dropIfExists('statuses_departments');
        Schema::dropIfExists('coworkers_departments');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('coworkers');
        Schema::dropIfExists('firms');
        Schema::dropIfExists('firms_types');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('users');

        \DB::commit();
    }
}
