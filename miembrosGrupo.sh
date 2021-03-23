#!/bin/bash

grupo=$1
i=0
res=""

IFS=':'
while read nombre x id gid resto
do
	if [ $gid -eq $grupo ]
	then
		if [ $i -eq 0 ]
		then
			res=$nombre
			((i++))
		else
			res="$res;$nombre"
		fi
	fi
done </etc/passwd

echo $res