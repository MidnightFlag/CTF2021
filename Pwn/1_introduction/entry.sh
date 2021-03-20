#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:4444,reuseaddr,fork EXEC:'/home/pwn/introduction,stderr'" - pwn;
done
