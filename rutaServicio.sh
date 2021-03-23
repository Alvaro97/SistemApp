#!/bin/bash

servicio=$1

ruta=`systemctl status $servicio | grep Loaded | awk '{print $3}'`

echo $ruta