# rpi-fishtankcontrol

A little hobby project to control and monitor an aquarium with a Raspberry PI, a 4 relay board and a DS18B20 temperature sensor. You can attach anything to the relay board, like lights or air pump.

I'm using Archlinux with lighttpd and php and rrdtool, so these should be installed first.

To create the rrd database:

```
TODO
```

To the crontab:

```
*/5 * * * * /srv/http/data/rrd.sh
```
