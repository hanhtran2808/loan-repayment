<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanRepaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_repayment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('loan_id');
            /**
             * original amount that user have to repay
             */
            $table->double('original_amount', 15, 2)->default(0);
            /**
             * amount get interest rate base on term
             * unit: %
             */
            $table->double('interest_amount', 15, 2)->default(0);
            $table->timestamps();
            $table->foreign('loan_id')->references('id')->on('loans')
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
        Schema::dropIfExists('loan_repayment');
    }
}
