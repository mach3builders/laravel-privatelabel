<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivatelabelTable extends Migration
{
    public function up()
    {
        $model = config('privatelabel.owner_model');

        Schema::create('private_labels', function (Blueprint $table) use ($model) {
            $table->id();
            $table->foreignId('owner_id')->constrained($model)->onDelete('cascade')->onUpdate('cascade');
            $table->string('domain');
            $table->string('name');
            $table->string('email');
            $table->integer('logo_login_height')->nullable();
            $table->integer('logo_app_height')->nullable();

            $table->string('status')->nullable();
            $table->unsignedBigInteger('forge_site_id')->nullable();
            $table->timestamps();
        });
    }
};
