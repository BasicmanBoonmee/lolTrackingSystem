<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStartProject extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email');
            $table->string('phone');
			$table->string('code');
            $table->integer('payment_term');
			$table->timestamps();
		});

        Schema::create('type_rate', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('symbol');
            $table->timestamps();
        });

        Schema::create('projects', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('status');
            $table->integer('total_price');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('dead_line');
            $table->timestamps();
        });

        Schema::create('linguist_level', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->decimal('rate_word',11,2);
            $table->decimal('rate_hourly',11,2);
            $table->timestamps();
        });

        Schema::create('linguist', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->integer('guaranteed_income');
            $table->integer('daily_capacity');
            $table->text('note');
            $table->integer('linguist_levelFK');
            $table->timestamps();
        });

        Schema::create('project_types', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('projectsFK');
            $table->integer('price');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('project_linguist', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('projectsFK');
            $table->integer('linguistFK');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('payments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('projectsFK');
            $table->dateTime('invoiced_date');
            $table->dateTime('expected_date');
            $table->dateTime('received_date');
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
		Schema::drop('clients');
        Schema::drop('type_rate');
        Schema::drop('projects');
        Schema::drop('linguist_level');
        Schema::drop('linguist');
        Schema::drop('project_types');
        Schema::drop('project_linguist');
        Schema::drop('payments');
	}

}
