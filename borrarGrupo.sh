#!/bin/bash

grupo=$1

>/etc/group2

IFS=':'
while read nombre resto
do
	if [[ $nombre != $grupo ]]
	then
		echo "$nombre:$resto">>/etc/group2
	fi
done </etc/group

rm /etc/group
mv /etc/group2 /etc/group