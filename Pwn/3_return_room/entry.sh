#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:6666,reuseaddr,fork EXEC:'/home/pwn/return_room,stderr'" - pwn;
done
