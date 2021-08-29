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
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('productTitle');
            $table->float('productQuantity');
            $table->string('productUnit')->nullable();
            $table->float('productUnitPrice');
            $table->float('productAmount');
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
