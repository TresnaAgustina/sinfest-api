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
      $table->foreignUuid('visitor_id')
        ->references('uuid')
        ->on('visitors')
        ->onDelete('cascade');
      $table->timestamp('order_date');
      $table->string('receipt_url', 80);
      $table->boolean('isValid')->default(false);
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
