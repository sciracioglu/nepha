<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('stakeholderType');
            $table->string('city');
            $table->string('plate');
            $table->string('togln');
            $table->string('corp');
            $table->string('gtin');
            $table->string('bn');
            $table->string('production_identifier');
            $table->float('loaded_activity', 10, 2);
            $table->integer('loaded_unit_id');
            $table->float('calibration_activity', 10, 2);
            $table->integer('calibration_unit_id');
            $table->date('load_date');
            $table->integer('dt');
            $table->string('country_code', 3);
            $table->date('xd');
            $table->string('uc', 5);
            $table->dateTime('cancel_date');
            $table->integer('cancel_user');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('products');
    }
}
