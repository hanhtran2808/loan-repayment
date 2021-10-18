<?php


namespace App\Repositories\Interfaces;



interface LoanRepositoryInterface extends BaseRepositoryInterface
{
    public function loanRequest($userId, $amount, $interestRate);
    public function updateLoanStatus($loanId, $status);
    public function repayLoan($loanId, $originalAmount, $interestAmount);
}