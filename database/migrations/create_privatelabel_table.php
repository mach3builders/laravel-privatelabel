<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivatelabelTable extends Migration
{
    public function up()
    {
        $model = config('private-label.owner_model');
        $model = new $model;

        Schema::create('private_labels', function (Blueprint $table) use ($model) {
            $table->id();
            $table->foreignId('owner_id')->constrained($model->getTable())->onDelete('cascade')->onUpdate('cascade');
            $table->string('domain');
            $table->string('name');
            $table->string('email')->nullable();
            $table->integer('logo_login_height')->nullable();
            $table->integer('logo_app_height')->nullable();

            $table->boolean('email_verified')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('forge_site_id')->nullable();
            $table->timestamps();
        });
    }
};
