<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('customerName')->nullable();
            $table->date('date');
            $table->string('currency');
            $table->string('currencyPosition');
            $table->string('customerAddress')->nullable();
            $table->string('customerPhone')->nullable();
            $table->date('deliveryDate')->nullable();
            $table->time('deliveryTime')->nullable();
            $table->float('tax')->nullable();
            $table->float('discount')->nullable();
            $table->float('advancePayment')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
