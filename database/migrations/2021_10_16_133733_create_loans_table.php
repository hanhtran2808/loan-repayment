<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            /**
             * loan code
             */
            $table->string('loan_no', 12);
            /**
             * amount that user want to loan
             */
            $table->double('amount', 15, 2)->default(0);
            /**
             * loan term date (maybe flexible in cases: weekly, monthly)
             */
            $table->timestamp('loan_term_at')->nullable();
            /**
             * interest rate base on term (such as: weekly, monthly)
             * unit: %
             */
            $table->integer('interest_rate')->default(0);
            /**
             * the status of loan. there are 3 value:
             * 0: request
             * 1: approve
             * 2; DONE
             */
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
