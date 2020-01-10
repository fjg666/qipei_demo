<?php
require_once (dirname(dirname(__FILE__)).'/config/db_config.php');
require_once dirname(MO_WEBAPP_DIR).'/vendor/autoload.php';

class LaiKeDBHelper
{
    public static function  init()
    {
        $connections = array(
            'production' => 'mysql://'.MYSQL_USER.':'.MYSQL_PASSWORD.'@'.MYSQL_SERVER.'/'.MYSQL_DATABASE
        );
        ActiveRecord\Config::initialize(function ($cfg) use ($connections) {

            $modelpath = dirname(dirname(__FILE__)) . "/modules/model,".dirname(dirname(__FILE__)).'/*/'.'';

            $cfg->set_model_directory($modelpath);
            $cfg->set_connections($connections);
        });
    }
}