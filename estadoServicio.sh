#!/bin/bash

servicio=$1

ruta=`systemctl status $servicio | grep Active | awk '{print $2}'`

echo $ruta