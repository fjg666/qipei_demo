<?php
$s = php_uname('s');
if ($s == 'Linux') {
    $lll = dirname(__FILE__).'/webapp/lib/sf/sf_billserver.sh';
    exec($lll);
}else{
    $lll = dirname(__FILE__).'\webapp\lib\sf\RUN-SF-PRINTER.bat';
    exec($lll);
}
?>