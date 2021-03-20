#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:5555,reuseaddr,fork EXEC:'/home/pwn/prison_break,stderr'" - pwn;
done
