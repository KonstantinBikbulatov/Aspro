<?php


class Product extends Model
{
    const TABLE = "products";
    const COLUMNS = [
        'name' => 'VARCHAR(30)',
        'price' => 'INT'
    ];
}