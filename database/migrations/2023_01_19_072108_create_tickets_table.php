<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('ticket_name');
            $table->string('ticket_code')->unique();
            $table->foreignUuid('order_uuid')
                ->references('uuid')
                ->on('orders')
                ->onDelete('cascade');
            $table->string('unique_code')->unique();
            $table->boolean('is_check_in')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
