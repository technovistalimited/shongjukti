<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_types', function (Blueprint $table) {
            $table->increments('id');

            $table->string('scope_key', 191)->comment('Unique identifier for each type of parent entity/scope');
            $table->string('name', 255);
            $table->string('name_bn', 300)->nullable();
            $table->string('accepted_extensions', 500)->nullable()->comment('Comma-separated extensions that are accepted with this attachment');
            $table->integer('weight')->nullable()->unsigned();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_label_accepted')->default(false);

            $table->bigInteger('created_by')->nullable()->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

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
        Schema::dropIfExists('attachment_types');
    }
}
