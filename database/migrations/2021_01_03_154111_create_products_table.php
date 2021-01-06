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
            $table->string('dt', 1);
            $table->string('country_code', 3);
            $table->date('xd');
            $table->string('uc', 5);
            $table->bigInteger('bildirim_id');
            $table->text('response_json')->nullable();
            $table->unsignedBigInteger('created_user');
            $table->timestamp('cancel_date')->nullable();
            $table->unsignedBigInteger('cancel_user')->nullable();
            $table->bigInteger('cancel_bildirim_id')->nullable();
            $table->timestamps();

            $table->foreign('created_user')
                ->references('id')
                ->on('users');

            $table->foreign('cancel_user')
                ->references('id')
                ->on('users');
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
