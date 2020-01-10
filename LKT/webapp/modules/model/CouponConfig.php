<?php


class CouponConfig extends ActiveRecord\Model
{
    static $table_name = 'lkt_coupon_config';
    static $primary_key = 'id';
    static $connection = 'production';

    public function __construct(array $attributes = array(), $guard_attributes = true, $instantiating_via_find = false, $new_record = true)
    {
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    }

    public function list1(array $attributes){
        $this->save($attributes);
    }

    public function list2(){
        self::count();
    }



}