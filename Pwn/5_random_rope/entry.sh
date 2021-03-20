#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:8888,reuseaddr,fork EXEC:'/home/pwn/random_rope,stderr'" - pwn;
done
