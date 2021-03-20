#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:7777,reuseaddr,fork EXEC:'/home/pwn/canary_friendly,stderr'" - pwn;
done
