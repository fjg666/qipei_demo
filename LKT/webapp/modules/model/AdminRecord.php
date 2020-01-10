<?php
class AdminRecord extends ActiveRecord\Model
{
    static $table_name = 'lkt_admin_record';
    static $primary_key = 'id';
    static $connection = 'production';
}