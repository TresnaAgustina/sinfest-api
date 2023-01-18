<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('visitor_uuid')
                ->references('uuid')
                ->on('visitors')
                ->onDelete('cascade');
            $table->foreignUuid('presale_uuid')
                ->references('uuid')
                ->on('presales')
                ->onDelete('cascade');
            $table->integer('amount')->default(0);
            $table->string('receipt_url');
            $table->boolean('is_valid')->default(false);
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
        Schema::dropIfExists('orders');
    }
}
