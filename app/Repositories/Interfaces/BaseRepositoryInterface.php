<?php


namespace App\Repositories\Interfaces;


interface BaseRepositoryInterface
{
    public function store(array $inputs);
    public function update($id, array $inputs);
    public function findById($id);
}