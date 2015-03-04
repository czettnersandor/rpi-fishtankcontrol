#!/bin/sh

CWD=$(pwd)
cd /srv/http/data

date=$(date +'%s')
from=$(date -d now-1day +'%s')
fromweek=$(date -d now-1week +'%s')
light=$(gpio read 0)
temperature=$(cat /sys/bus/w1/devices/28-04146de3f5ff/w1_slave | sed -n 's/^.*\(t=[^ ]*\).*/\1/p' | sed 's/t=//' | awk '{x=$1}END{print(x/1000)}')

echo $temperature > temperature

if [ "$light" = "0" ]; then
    rrdlight=1
else
    rrdlight=0
fi

rrdtool update light.rrd $date:$rrdlight
rrdtool update temperature.rrd $date:$temperature

rrdtool graph light-1d.png --start $from --end $date DEF:light=light.rrd:light:AVERAGE LINE2:light#FF0000
rrdtool graph light-1w.png --start $fromweek --end $date DEF:light=light.rrd:light:AVERAGE LINE2:light#FF0000

rrdtool graph temperature-1d.png --start $from --end $date DEF:temperature=temperature.rrd:temperature:AVERAGE LINE2:temperature#00FF00
rrdtool graph temperature-1w.png --start $fromweek --end $date DEF:temperature=temperature.rrd:temperature:AVERAGE LINE2:temperature#00FF00
cd $PWD
