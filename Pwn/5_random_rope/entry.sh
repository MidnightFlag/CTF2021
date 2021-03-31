#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:9024,reuseaddr,fork EXEC:'/home/pwn/random_rope,stderr'" - pwn;
done
