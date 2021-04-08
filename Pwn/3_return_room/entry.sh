#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:9022,reuseaddr,fork EXEC:'/home/pwn/return_room,stderr'" - pwn;
done
