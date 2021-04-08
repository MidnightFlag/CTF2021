#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:9000,reuseaddr,fork EXEC:'python3 /chall/chall.py',stderr,pty,echo=0" - challenger;
done
