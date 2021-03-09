import hashlib
import sys
import random
import string
import time
from num2words import num2words

def getRandomString(length):
    letters = string.ascii_lowercase
    return ''.join(random.choice(letters) for i in range(length))

def getCalculNumber():
    possible = ["*","+","-","%"]
    return str(random.randint(1,100))+" "+possible[random.randint(0,len(possible)-1)]+" "+str(random.randint(1,100))+" "+possible[random.randint(0,len(possible)-1)]+" "+str(random.randint(1,100))

def getCalculLiteral():
    toReturn = []
    possible = ["*","+","-","%"]
    first = random.randint(1,100)
    second = random.randint(1,100)
    third = random.randint(1,100)
    calcul = str(first)+" "+possible[random.randint(0,len(possible)-1)]+" "+str(second)+" "+possible[random.randint(0,len(possible)-1)]+" "+str(third)
    toReturn.append(calcul)
    if(random.randint(0,1) == 0): calcul = calcul.replace(str(first),num2words(first))
    if(random.randint(0,1) == 0): calcul = calcul.replace(str(second),num2words(second))
    if(random.randint(0,1) == 0): calcul = calcul.replace(str(third),num2words(third))
    toReturn.append(calcul)
    return toReturn

def challenge():
    i = 0
    while i<10:
        calcul = getCalculNumber()
        print("What is the result of "+calcul+" ?")
        start_time = time.time()
        choix = input()
        if(time.time() - start_time > 0.5):
            print("Too late!")
            sys.exit(0)
        try:
            if(int(eval(calcul)) != int(choix)):
                print("Wrong result, goodbye.")
                sys.exit(0)
        except Exception as e:
            if("literal" in str(e).lower()):
                print("I'm waiting for a number here, not a string, get out!")
                sys.exit(0)
        i += 1
    i = 0
    while i<50:
        calcul = getCalculLiteral()
        print("What is the result of "+calcul[1]+" ?")
        start_time = time.time()
        choix = input()
        if(time.time() - start_time > 0.5):
            print("Too late!")
            sys.exit(0)
        try:
            if(int(eval(calcul[0])) != int(choix)):
                print("Wrong result, goodbye.")
                sys.exit(0)
        except Exception as e:
            if("literal" in str(e).lower()):
                print("I'm waiting for a number here, not a string, get out!")
                sys.exit(0)
        i += 1
    print("Well done, here is your flag : MCTF{th3_p4th_w4s_l0ng_but_y0u_g0t_1t}")


def main():
    print('''Hi you,
    Are you ready for the challenge?(yes/no)''')
    choix = input()
    if(choix.lower() != "yes" and choix.lower() != "no"): sys.exit(0)
    if(choix.lower() == "no"):
        print("Ok goodbye, come back when you will be ready.")
        sys.exit(0)
    else:
        challenge()

if __name__ == "__main__":
    main()
    sys.exit(0)
