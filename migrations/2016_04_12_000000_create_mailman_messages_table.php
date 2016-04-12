<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMailmanMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('mailman.storage.database.table'), function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->string('message_id', 512);
            $table->string('content_type', 64);

            $table->enum('status', ['allowed', 'denied']);

            $table->mediumText('from', 512);
            $table->mediumText('to', 512);
            $table->mediumText('reply_to', 512)->nullable();

            $table->mediumText('cc')->nullable();
            $table->mediumText('bcc')->nullable();

            $table->string('subject');
            $table->mediumText('body');

            $table->mediumText('instance');

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
        Schema::drop(config('mailman.storage.database.table'));
    }
}
