#!/bin/sh

CWD=$(pwd)
cd /srv/http/data

date=$(date +'%s')
from=$(date -d now-1day +'%s')
fromweek=$(date -d now-1week +'%s')
light=$(cat gpio0)

echo `pwd`

if [ "$light" = "0" ]; then
    rrdlight=1
else
    rrdlight=0
fi

rrdtool update light.rrd $date:$rrdlight

rrdtool graph light-1d.png --start $from --end $date DEF:light=light.rrd:light:AVERAGE AREA:light#FF0000
rrdtool graph light-1w.png --start $fromweek --end $date DEF:light=light.rrd:light:AVERAGE AREA:light#FF0000

cd $PWD
