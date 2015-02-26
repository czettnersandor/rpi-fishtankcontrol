# rpi-fishtankcontrol

A little hobby project to control and monitor an aquarium with a Raspberry PI, a 4 relay board and a DS18B20 temperature sensor. You can attach anything to the relay board, like lights or air pump.

I'm using Archlinux with lighttpd and php and rrdtool, so these should be installed first.

To create the rrd database:

```
rrdtool create /srv/http/data/light.rrd --start 1424721600 DS:light:GAUGE:600:0:2 RRA:AVERAGE:0.5:1:600 RRA:AVERAGE:0.5:6:700 RRA:AVERAGE:0.5:24:775 RRA:AVERAGE:0.5:288:797

rrdtool create /srv/http/data/temperature.rrd --start 1424721600 DS:temperature:GAUGE:600:0:50 RRA:AVERAGE:0.5:1:600 RRA:AVERAGE:0.5:6:700 RRA:AVERAGE:0.5:24:775 RRA:AVERAGE:0.5:288:797
```

To the crontab:

```
*/5 * * * * /srv/http/data/rrd.sh
```
