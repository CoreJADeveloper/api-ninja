<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('category_id');
            $table->string('field_type');
            $table->boolean('enable_rating')->default(0);
            $table->boolean('enable_filtering')->default(0);
            $table->boolean('mandatory')->default(0);
            $table->boolean('disabled')->default(0);
            $table->integer('total_used')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('parameters');
    }
}
