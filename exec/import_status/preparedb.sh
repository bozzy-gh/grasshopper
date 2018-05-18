#!/bin/bash

"$( dirname "$(readlink -f "$0")" )"/../monitor/SendCommand.py '*#1*0##' >"$( dirname "$(readlink -f "$0")" )"/lightstatus.txt
sed -i 's/*/,/g' "$( dirname "$(readlink -f "$0")" )"/lightstatus.txt
sed -i 's/^,//g' "$( dirname "$(readlink -f "$0")" )"/lightstatus.txt
sed -i 's/##//g' "$( dirname "$(readlink -f "$0")" )"/lightstatus.txt
mysql --local-infile=1 -u root --database=domotica --verbose <"$( dirname "$(readlink -f "$0")" )"/lightstatus.sql
