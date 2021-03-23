#!/bin/bash

>gruposSistema.txt
>gruposPersonales.txt

IFS=':'
while read nombre x gid miembros
do
	if [ $gid -lt 1000 ] || [ $gid -eq 65534 ]
	then
		echo "$nombre:$gid:$miembros">>gruposSistema.txt
	else
		echo "$nombre:$gid:$miembros">>gruposPersonales.txt
	fi
done </etc/group