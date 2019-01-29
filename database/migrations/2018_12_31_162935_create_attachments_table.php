<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('scope_key', 191)->nullable()->comment('Unique identifier for parent entity/scope');
            $table->integer('scope_id')->nullable()->unsigned()->comment('Parent to that particular entity/scope with which the item is attached to');
            $table->integer('attachment_type_id')->unsigned()->comment('Relation to attachment_types if applicable');
            $table->string('attachment_label', 300)->nullable();
            $table->string('mime_type', 100);
            $table->string('attachment_path', 500);

            // relationship
            $table->foreign('attachment_type_id')->references('id')->on('attachment_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
