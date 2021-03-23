#!/bin/bash

grupo=$1
usuario=$2

>/etc/group2

IFS=':'
while read nombre x gid miembros
do
	if [[ $nombre = $grupo ]]
	then
		echo "$nombre:$x:$gid:$miembros$usuario">>/etc/group2
	else
		echo "$nombre:$x:$gid:$miembros">>/etc/group2
	fi
done </etc/group

rm /etc/group
mv /etc/group2 /etc/group