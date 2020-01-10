<?php

class Record extends ActiveRecord\Model
{
    static $table_name = 'lkt_record';
    static $primary_key = 'id';
    static $connection = 'production';
}