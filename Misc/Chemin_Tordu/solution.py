from pwn import *
import hashlib
import words2num
s = remote("<SERVER>",<PORT>)
s.recv()
s.send("yes\n")
i = 0
while i<10:
    toCompute = str(s.recv()).split("of ")[1].split(" ?")[0]
    toCompute = hashlib.md5(toCompute.encode())
    s.send(toCompute.hexdigest()+"\n")
    i += 1
i = 0
while i<10:
    toCompute = str(s.recv()).split("of ")[1].split(" ?")[0]
    toCompute = hashlib.sha1(toCompute.encode())
    s.send(toCompute.hexdigest()+"\n")
    i += 1
i = 0
while i<10:
    toCompute = str(s.recv()).split("of ")[1].split(" ?")[0]
    s.send(str(eval(toCompute))+"\n")
    i += 1
k = 0
while k<50:
    toCompute = str(s.recv()).split("of ")[1].split(" ?")[0]
    toAdd = []
    for i in toCompute.split(" "):
        if(i == "by"):
            pass
        else:
            try:
                toAdd.append(str(words2num.w2n(i)))
            except:
                    toAdd.append(str(i))
    ope = ''.join(toAdd)
    s.send(str(eval(ope))+"\n")
    k += 1
print(s.recv())
