#!/bin/bash

usuario=$1

>/etc/shadow2
>/etc/passwd2
>/etc/group2
IFS=':'

while read nombre password resto
do
	if [[ $nombre != $usuario ]]
	then
		echo "$nombre:$password:$resto">>/etc/shadow2
	fi
done </etc/shadow

rm /etc/shadow
mv /etc/shadow2 /etc/shadow

while read nombre resto
do
	if [[ $nombre != $usuario ]]
	then
		echo "$nombre:$resto">>/etc/passwd2
	fi
done </etc/passwd

rm /etc/passwd
mv /etc/passwd2 /etc/passwd

while read nombre resto
do
	if [[ $nombre != $usuario ]]
	then
		echo "$nombre:$resto">>/etc/group2
	fi
done </etc/group

rm /etc/group
mv /etc/group2 /etc/group
