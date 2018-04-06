<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('properties', function (Blueprint $table) {
      $table->uuid('id');
      $table->timestamps();

      $table->string('address_line1', 255);
      $table->string('address_line2', 255)->nullable();
      $table->string('address_city_town', 255);
      $table->string('address_postcode', 255);
      $table->decimal('lat', 10,6);
      $table->decimal('lng', 10,6);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('properties');
  }
}
