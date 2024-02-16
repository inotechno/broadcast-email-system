<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('subject');
            $table->string('from_name')->nullable();
            $table->string('from_email')->nullable();
            $table->boolean('is_html')->nullable();
            $table->text('message');
            $table->text('message_without_template');
            $table->dateTime('start_send_at');
            $table->enum('status', ['draft', 'active'])->default('draft');
            $table->foreignId('template_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->boolean('executed')->default(false);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('campaigns');
    }
}
