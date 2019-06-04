<?php


namespace App\Repository;


interface IRepository
{
    public function findOneByFields(string $filter, array $bind = []);

    public function findByFields(string $filter, array $bind = [], $sort = 'ASC');
}