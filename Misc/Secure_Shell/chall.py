import subprocess
import sys
def main():
    print('''Welcome to Secure Shell V1.0
This secure software is developed in python, and offers a new way to manage user rights.
This way to manager rights is to define which file user can't read. Example: secret_file.txt
You can leave the shell with exit command.

        Note : This is a test version. If you find any bug contact:
                    admin@secureshell.com
    ''')
    while True:
        pwd = subprocess.check_output(['pwd']).decode().strip("\n")
        command = input("user@secureshell:%s$ "%(pwd))
        try:
            if("secret_file.txt" in command.lower()):
                print("You need more rights to read secret_file.txt")
            else:
                if("chall.py" in command.lower()):
                    print("You can't read the source code of this software.")
                else:
                    if("sh" in command.lower()):
                        print("'Running another shell' event as been disabled by your administrator.")
                    else:
                        if("exit" in command.lower()):
                            sys.exit(-1)
                        if("/" not in command and ".." not in command):
                            if("cd" in command.lower()):
                                print("You don\'t have the rights to move into another folder.")
                            else:
                                if("history" not in command.lower() and "$" not in command.lower() and "rm" not in command.lower() and "python" not in command.lower()):
                                    command = command.split(" ")
                                    output_command = subprocess.check_output(command).decode().strip("\n")
                                    print(output_command)
                                else:
                                    print("'%s' command as been disabled by your administrator."%(command.split(" ")[0]))
                        else:
                            print("You don\'t have the rights to see content of other folders/files.")
        except Exception as e:
            print(e)
            print("Bad command.")
if __name__ == "__main__":
    main()