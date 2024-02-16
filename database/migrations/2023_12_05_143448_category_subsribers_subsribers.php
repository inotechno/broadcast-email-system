<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategorySubsribersSubsribers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_subscribers_subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_subscriber_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('subscriber_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('category_subscribers_subscribers');
    }
}
