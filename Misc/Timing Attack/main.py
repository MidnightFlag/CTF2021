import time
import sys

def verifyPassword(pwd):
    passwd = "MCTF{p4ssw0rd??}"
    for i in range(len(pwd)):
        if(pwd[i] == passwd[i]):
            time.sleep(0.5*i)
        else:
            print("Wrong pass...")
            return 0
    print("The time was precious..")

def main():
    print('''
        You know, the time is something very important.
        It scrolls through your fingers and will never come back.
        Use it well, it often opens doors for those who know how to wait.
    ''')
    pwd = input("What's the password ?\n")
    verifyPassword(pwd)
    sys.exit(-1)

if __name__ == "__main__":
    main()