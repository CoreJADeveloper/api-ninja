<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by');
            $table->boolean('manage_control_panel');
            $table->boolean('manage_categories');
            $table->boolean('manage_parameters');
            $table->boolean('manage_objects');
            $table->boolean('manage_collections');
            $table->boolean('manage_categories_collections');
            $table->integer('active_users')->default(0);
            $table->string('redirect');
            $table->boolean('default');
            $table->boolean('enabled')->default(1);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        DB::table('levels')->insert([
            [
                'name' => 'Admin',
                'created_by' => 0,
                'manage_control_panel' => true,
                'manage_categories' => true,
                'manage_parameters' => true,
                'manage_objects' => true,
                'manage_collections' => true,
                'manage_categories_collections' => true,
                'redirect' => url('/'),
                'default' => true
            ],
            [
                'name' => 'Editor',
                'created_by' => false,
                'manage_control_panel' => false,
                'manage_categories' => true,
                'manage_parameters' => true,
                'manage_objects' => true,
                'manage_collections' => true,
                'manage_categories_collections' => true,
                'redirect' => url('/'),
                'default' => true
            ],
            [
                'name' => 'Subscriber',
                'created_by' => false,
                'manage_control_panel' => false,
                'manage_categories' => false,
                'manage_parameters' => false,
                'manage_objects' => false,
                'manage_collections' => false,
                'manage_categories_collections' => false,
                'redirect' => url('/'),
                'default' => true
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('levels');
    }
}
