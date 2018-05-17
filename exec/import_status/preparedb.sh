#!/bin/bash
/var/www/exec/monitor/SendCommand.py '*#1*0##' >/var/www/exec/import_status/lightstatus.txt
sed -i 's/*/,/g' /var/www/exec/import_status/lightstatus.txt
sed -i 's/^,//g' /var/www/exec/import_status/lightstatus.txt
sed -i 's/##//g' /var/www/exec/import_status/lightstatus.txt
mysql --local-infile=1 -u root --database=domotica --verbose </var/www/exec/import_status/lightstatus.sql
