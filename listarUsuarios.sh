#!/bin/bash

>usuarios.txt
>usuariosSistema.txt
>usuariosPredefinidos.txt

IFS=':'
while read nombre x id gid info homedir shell
do
	if [ $id -ge 1000 ] && [ $id -le 20000 ]
	then
		echo "$nombre:$x:$id:$gid:$info:$homedir:$shell">>usuarios.txt
	elif [ $id -lt 100 ]
	then
		echo "$nombre:$x:$id:$gid:$info:$homedir:$shell">>usuariosPredefinidos.txt
	else
		echo "$nombre:$x:$id:$gid:$info:$homedir:$shell">>usuariosSistema.txt
	fi
done </etc/passwd
