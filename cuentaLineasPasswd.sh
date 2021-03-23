#!/bin/bash

i=0

IFS=':'
while read nombre x id resto
do
	if [ $id -ge 1000 ] && [ $id -le 50000 ]
	then
		((i++))
	fi
done </etc/passwd

echo $i