<?php
class Order extends ActiveRecord\Model
{
    static $table_name = 'lkt_order';
    static $primary_key = 'id';
    static $connection = 'production';
}