#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:9021,reuseaddr,fork EXEC:'/home/pwn/prison_break,stderr'" - pwn;
done
