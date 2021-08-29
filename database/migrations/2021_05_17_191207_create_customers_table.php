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
            $table->foreignId('user_id')
                ->constrained('users')
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
            $table->text('subject')->nullable();
            $table->text('termsAndConditions')->nullable();
            $table->text('lastMessage')->nullable();
            $table->text('signature')->nullable();
            $table->string('regardsName')->nullable();
            $table->string('regardsTitle')->nullable();
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
