#!/bin/sh
# source /etc/profile;
nohup java -jar /alidata/www/xiaochengxu/V3/webapp/lib/sf/csim_waybill_print_service_V1.1.3.jar >/usr/sf_billserver.out 2>&1 &
exit 1
