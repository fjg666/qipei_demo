<?php
class User extends ActiveRecord\Model
{
    static $table_name = 'lkt_user';
    static $primary_key = 'id';
    static $connection = 'production';
}