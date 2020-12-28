from discord.ext import commands
from discord.ext.commands import CommandNotFound
import discord
import mysql.connector 
TOKEN = "[REDACTED]"

database = mysql.connector.connect(
  host="146.59.156.82",
  user="[REDACTED]",
  password="[REDACTED]",
  database="bot",
  raise_on_warnings=True
)

intents = discord.Intents.all()
bot = commands.Bot(command_prefix='!',intents=intents)

def isAdmin(idTeam):
    cursor = database.cursor()
    cursor.execute("SELECT isAdmin FROM team WHERE id = %s", (idTeam,))
    isAdmin = cursor.fetchall()[0][0]
    cursor.close()

    if(isAdmin == 1): return True
    else: return False

async def upgradeToAdmin(id,ctx):
    VC = discord.utils.get(ctx.guild.channels, name=str(ctx.channel))
    adminrole = discord.utils.get(ctx.guild.roles, name="Admin")
    for user in VC.members:
        if(len(user.roles) <= 2): await user.add_roles(adminrole)
    await ctx.send("Welcome back admins, check #general for order of the week.")
    return

async def downgradeToGuest(ctx):
    VC = discord.utils.get(ctx.guild.channels, name=str(ctx.channel))
    adminrole = discord.utils.get(ctx.guild.roles, name="Admin")
    for user in VC.members:
        if(str(user.name) != "ManagerBot"): await user.remove_roles(adminrole)
    return

@bot.command(name='downgrade', help='For test.')
async def downgrade(ctx):
    cursor = database.cursor()
    cursor.execute("UPDATE team SET isAdmin=0 WHERE id=1")
    database.commit()
    cursor.close()
    await downgradeToGuest(ctx)
    await ctx.send("Downgrade done.")

@bot.command(name='author', help='Display author of this challenge.')
async def author(ctx):
    await ctx.send("Worty for your pleasure <3")

@bot.command(help='Method out of scope for the challenge.')
async def reconnectDB():
    if(database.is_connected() == False): database.connect()
    return

@bot.command(name='flag', help='Display the flag, or maybe not?')
async def author(ctx):
    await reconnectDB()
    await ctx.send("I will give you a part of the flag : MCTF{")

@bot.command(name='welcome', help="Display welcome message.")
async def welcome(ctx):
    await reconnectDB()
    await ctx.send("Welcome "+str(ctx.channel)+" team to the factory discord server. Here you can manage your current team, also, there is an admin part for developers but you can't access it. Start manage your team!")

@bot.command(name='add', help='Add a new member of your team.')
async def add(ctx, name=None):
    await reconnectDB()
    if name is None:
        await ctx.send("Missing a name for the new member. Usage : !add example")
        return
    if(len(name) <= 50):
        #Fetching team id
        channel = str(ctx.channel)
        cursor = database.cursor()
        cursor.execute("SELECT id FROM team WHERE name = %s", (channel,))
        currentTeamId = cursor.fetchall()[0][0]
        cursor.close()

        #Checking if team have done sqli to became admin
        if(isAdmin(currentTeamId) == True): await upgradeToAdmin(currentTeamId, ctx)

        #Fetching all members to verify that all pseudo are unique
        cursor = database.cursor()
        cursor.execute("SELECT pseudo FROM member WHERE team = %s", (currentTeamId,))
        allMembers = cursor.fetchall()
        cursor.close()

        if(len(allMembers) > 0):
            if(len(allMembers) < 4):
                for i in range(len(allMembers)):
                    if(allMembers[i][0] == name):
                        await ctx.send("This username is already taken, please choose another.")
                        return
            else:
                await ctx.send("There are already 4 members in your team. Cannont add another one.")
                return

        cursor = database.cursor()
        cursor.execute("INSERT INTO member(id,pseudo,team) VALUES(%s,%s,%s)", (0,name,currentTeamId,))
        database.commit()
        cursor.close()

        await ctx.send("Query success : Member %s was added."%(name))
    else: await ctx.send("Username must be at most 50 characters.")

@bot.command(name='show', help='Display current member of your team.')
async def show(ctx):
    await reconnectDB()
    channel = str(ctx.channel)

    #Fetching team id with the name of discord channel.
    cursor = database.cursor()
    cursor.execute("SELECT id FROM team WHERE name = %s", (channel,))
    currentTeamId = cursor.fetchall()[0][0]
    cursor.close()

    #Checking if team have done sqli to became admin
    if(isAdmin(currentTeamId) == True): await upgradeToAdmin(currentTeamId, ctx)

    #Fetching all members of the current team
    cursor = database.cursor()
    cursor.execute("SELECT id,pseudo FROM member WHERE team = %s", (currentTeamId,))
    allMembers = cursor.fetchall()
    cursor.close()

    if(len(allMembers) == 0): msg = "Currently, there is nobody in your team."
    else:
        if(len(allMembers) > 1): msg = "Currently, there are " + str(len(allMembers))+" member(s) in your team:\n"
        else: msg = "Currently, there is " + str(len(allMembers))+" member in your team:\n"
        msg += "- id : name\n"
        for i in range(len(allMembers)):
            msg += "- "+str(allMembers[i][0])+" : "+allMembers[i][1]+"\n"
    await ctx.send(msg)

@bot.command(name='delete', help='Delete a member from your team.')
async def delete(ctx, name=None):
    await reconnectDB()
    if name is None:
        await ctx.send("Missing a name for the new member. Usage : !delete example")
        return

    channel = str(ctx.channel)
    #Fetching team id with the name of discord channel.
    cursor = database.cursor()
    cursor.execute("SELECT id FROM team WHERE name = %s", (channel,))
    currentTeamId = cursor.fetchall()[0][0]
    cursor.close()

    #Checking if team have done sqli to became admin
    if(isAdmin(currentTeamId) == True): await upgradeToAdmin(currentTeamId, ctx)

    #Recovering all pseudo to verify if this pseudo is in the database
    cursor = database.cursor()
    cursor.execute("SELECT pseudo,id FROM member WHERE team = %s", (currentTeamId,))
    allMembers = cursor.fetchall()
    cursor.close()

    isInDb = False
    idMember = -1
    if(len(allMembers) > 0):
        for i in range(len(allMembers)):
            if(allMembers[i][0] == name):
                isInDb = True
                idMember = allMembers[i][1]
                break
    
    if(isInDb == True):
        #Deleting task of the user
        cursor = database.cursor()
        cursor.execute("DELETE FROM tasks WHERE member = %s",(idMember,))
        database.commit()
        cursor.close()

        #Deleting the user
        cursor = database.cursor()
        cursor.execute("DELETE FROM member WHERE pseudo = %s AND team = %s", (name,currentTeamId,))
        database.commit()
        cursor.close()

        await ctx.send("Query success : Member %s was deleted."%(name))
    else: await ctx.send("Unknown username %s."%(name))

@bot.command(name='addTask', help='Add a new task for your project.')
async def addTask(ctx, member=None, title=None, *, description=None):
    await reconnectDB()
    if title is None:
        await ctx.send("Missing a title for the new task. Usage : !addTask member title description\nNote: The description can contain space.")
        return
    if member is None:
        await ctx.send("Missing a member for the new task. Usage : !addTask member title description\nNote: The description can contain space.")
        return
    if description is None:
        await ctx.send("Missing a description for the new task. Usage: !addTask member title description\nNote: The description can contain space.")
    if(len(title) <= 300):
        if(len(description) <= 300):
            channel = str(ctx.channel)
            #Fetching team id with the name of discord channel.
            cursor = database.cursor()
            cursor.execute("SELECT id FROM team WHERE name = %s", (channel,))
            currentTeamId = cursor.fetchall()[0][0]
            cursor.close()

            #Checking if team have done sqli to became admin
            if(isAdmin(currentTeamId) == True): await upgradeToAdmin(currentTeamId, ctx)

            #Recovering all pseudo to verify if this pseudo is in the database
            cursor = database.cursor()
            cursor.execute("SELECT id,pseudo FROM member WHERE team = %s", (currentTeamId,))
            allMembers = cursor.fetchall()
            nameOfMember = ""
            cursor.close()

            ##We have to verif if the task is already existing
            #Fetching all task of a team
            allTasks = []
            for i in range(len(allMembers)):
                cursor = database.cursor()
                cursor.execute("SELECT title,member FROM tasks WHERE member = %s", (allMembers[i][0],))
                tasks = cursor.fetchall()
                cursor.close()
                if(len(tasks) > 0):
                    allTasks.append(tasks)
            if(len(allTasks) > 0):
                index = [k for k,  tupl in enumerate(allTasks[0]) if tupl[0] == title]
                if(len(index) > 0):
                    index2 = [k for k,  tupl in enumerate(allMembers) if tupl[0] == allTasks[0][index[0]][1]]
                    await ctx.send("This task already exist and have to be done by %s"%(allMembers[index2[0]][1]))
                    return

            if(len(allMembers) > 0):
                for i in range(len(allMembers)):
                    if(allMembers[i][1] == member):
                        nameOfMember = allMembers[i][0]
                        break
                if(nameOfMember != ""):
                    cursor = database.cursor()
                    cursor.execute("INSERT INTO tasks(id,title,member,description) VALUES(%s,%s,%s,%s)",(0,title,nameOfMember,description,))
                    database.commit()
                    cursor.close()
                    await ctx.send("Query success : Task %s was added."%(title))
                else: await ctx.send("Unknown member %s."%(member))
            else: await ctx.send("You don't have any member in your team. Cannot add the task.")
        else: await ctx.send("Description must be at most 300 characters.")
    else: await ctx.send("Title must be at most 300 characters.")

@bot.command(name='showTasks', help='Display all current tasks of your team.')
async def showTasks(ctx):
    await reconnectDB()
    channel = str(ctx.channel)

    #Fetching team id with the name of discord channel.
    cursor = database.cursor()
    cursor.execute("SELECT id FROM team WHERE name = %s", (channel,))
    currentTeamId = cursor.fetchall()[0][0]
    cursor.close()
    
    #Checking if team have done sqli to became admin
    if(isAdmin(currentTeamId) == True): await upgradeToAdmin(currentTeamId, ctx)
    #Fetching all members id of the current team
    cursor = database.cursor()
    cursor.execute("SELECT id,pseudo FROM member WHERE team = %s", (currentTeamId,))
    allMembers = cursor.fetchall()
    cursor.close()
    if(len(allMembers) == 0): 
        await ctx.send("Currently, there is nobody in your team.")
        return
    else:
        #Fetching all tasks of the current team
        allTasks = []
        for i in range(len(allMembers)):
            cursor = database.cursor()
            cursor.execute("SELECT title,member FROM tasks WHERE member = %s", (allMembers[i][0],))
            tasks = cursor.fetchall()
            if(len(tasks) > 0):
                allTasks.append(tasks)
            cursor.close()
        if(len(allTasks) > 0):
            msg = "Currently, your team have %s tasks:\n"
            nb = 0
            for i in range(len(allTasks)):
                if(len(allTasks[i]) == 1):
                    index = [k for k,  tupl in enumerate(allMembers) if tupl[0] == allTasks[i][0][1]][0]
                    msg += allMembers[index][1] + " : " + allTasks[i][0][0]+"\n"
                    nb += 1
                else:
                    for j in range(len(allTasks[i])):
                        index = [k for k,  tupl in enumerate(allMembers) if tupl[0] == allTasks[i][j][1]][0]
                        msg += allMembers[index][1] + " : " + allTasks[i][j][0]+"\n"
                        nb += 1
            await ctx.send(msg%(str(nb)))
        else: await ctx.send("No current task found for your team.")

@bot.command(name='showOneTask', help='Display a specific task of your team.')
async def showOneTask(ctx, idMember=None, *, name=None):
    await reconnectDB()
    channel = str(ctx.channel)

    #Fetching team id with the name of discord channel.
    cursor = database.cursor()
    cursor.execute("SELECT id FROM team WHERE name = %s", (channel,))
    currentTeamId = cursor.fetchall()[0][0]
    cursor.close()

    #Checking if team have done sqli to became admin
    if(isAdmin(currentTeamId) == True): await upgradeToAdmin(currentTeamId, ctx)
    #Fetching all members id of the current team
    cursor = database.cursor()
    cursor.execute("SELECT id,pseudo FROM member WHERE team = %s", (currentTeamId,))
    allMembers = cursor.fetchall()
    cursor.close()

    if name is None:
        await ctx.send("Missing a name for the task to display. Usage: !showOneTask idMember name")
        return
    if idMember is None:
        msg = "Missing an id for the task to display. Usage: !showOneTask idMember name\nIds of your team are:\n"
        for i in range(len(allMembers)):
            msg += "- "+str(allMembers[i][0])+" : "+allMembers[i][1]+"\n"
        await ctx.send(msg)
        return

    isIdOwnByTeam = False
    for i in range(len(allMembers)):
        if(idMember == str(allMembers[i][0])):
            isIdOwnByTeam = True
            break
    
    if(isIdOwnByTeam == True):
        if(len(allMembers) == 0): 
            await ctx.send("Currently, there is nobody in your team.")
            return
        else:
            #Fetching all tasks of the current team
            try:
                if("insert" in name.lower() or "delete" in name.lower()):
                    await ctx.send("Insert or Delete queries are out of scope.")
                    return

                cursor = database.cursor()
                query = "SELECT description,member FROM tasks WHERE member = %s AND title = '%s'"%(idMember,name,)
                if("update" in name.lower()):
                    for _ in cursor.execute(query,multi=True):
                        pass
                    database.commit()
                else: 
                    cursor.execute(query)
                    tasks = cursor.fetchall()
                cursor.close()
            except Exception as e:
                if("update" in name.lower() and "--" in e.msg or "/**" in e.msg): 
                    database.commit()
                    await ctx.send("Query success : Empty result.")
                    return
                else:
                    try:
                        if(tasks):
                            print(tasks)
                            index = [k for k,  tupl in enumerate(allMembers) if tupl[0] == tasks[0][1]]
                            if(len(index) > 0):
                                member = allMembers[index[0]][1]
                                msg = "%s have to done the task %s which consist to %s"%(member,name,tasks[1][0])
                            else: 
                                msg = "Unknown member, displaying the gross result\n"
                                member = tasks[0][1]
                                msg += "%s have to done the task %s which consist to %s"%(member,name,tasks[0][0])
                            await ctx.send(msg)
                            return 
                        else:
                            await ctx.send("Query success: Empty result.")
                            return
                    except:
                        await ctx.send("Bot cannot achieve the command. Error %s"%(e))
                        return
            try:
                if(len(tasks) > 0):
                    index = [k for k,  tupl in enumerate(allMembers) if tupl[0] == tasks[0][1]]
                    if(len(index) > 0):
                        member = allMembers[index[0]][1]
                        msg = "%s have to done the task %s which consist to %s"%(member,name,tasks[0][0])
                    else: 
                        msg = "Unknown member, displaying the gross result\n"
                        member = tasks[0][1]
                        msg += "%s have to done the task %s which consist to %s"%(member,name,tasks[0][0])
                    await ctx.send(msg)
                else: 
                    index = [k for k,  tupl in enumerate(allMembers) if tupl[0] == int(idMember)]
                    member = allMembers[index[0]][1]
                    await ctx.send("Query error: %s is not existing for member %s."%(name,member))
            except:
                await ctx.send("Query success : Empty result.")
    else:
        msg = "Unknown id "+idMember+" in your team. Available ids are:\n"
        for i in range(len(allMembers)):
            msg += "- "+str(allMembers[i][0])+" : "+allMembers[i][1]+"\n"
        await ctx.send(msg)

@bot.command(name='removeTask', help='Remove a task.')
async def removeTask(ctx, title=None):
    await reconnectDB()
    if title is None:
        await ctx.send("Missing a title for deleting the task. Usage : !removeTask example")
        return
    channel = str(ctx.channel)

    #Fetching team id with the name of discord channel.
    cursor = database.cursor()
    cursor.execute("SELECT id FROM team WHERE name = %s", (channel,))
    currentTeamId = cursor.fetchall()[0][0]
    cursor.close()

    #Checking if team have done sqli to became admin
    if(isAdmin(currentTeamId) == True): await upgradeToAdmin(currentTeamId, ctx)

    #Fetching all members id of the current team
    cursor = database.cursor()
    cursor.execute("SELECT id FROM member WHERE team = %s", (currentTeamId,))
    allMembers = cursor.fetchall()
    cursor.close()

    if(len(allMembers) == 0): 
        await ctx.send("Currently, there is nobody in your team.")
        return
    else:
        ids = []
        for i in range(len(allMembers)):
            ids.append(allMembers[i][0])

        #Fetching all tasks of the current team
        allTasks = []
        for i in range(len(ids)):
            cursor = database.cursor()
            cursor.execute("SELECT title,member FROM tasks WHERE member = %s", (ids[i],))
            tasks = cursor.fetchall()
            cursor.close()

            if(len(tasks) > 0):
                allTasks.append(tasks)
        idMember = ""
        for i in range(len(allTasks)):
            if(len(allTasks[i]) == 1):
                if(allTasks[i][0][0] == title):
                    idMember = allTasks[i][0][1]
                    break
            else:
                for j in range(len(allTasks[i])):
                    if(allTasks[i][j][0] == title):
                        idMember = allTasks[i][j][1]
                        break

        if(idMember != ""):
            cursor = database.cursor()
            cursor.execute("DELETE FROM tasks WHERE title = %s AND member = %s", (title,idMember,))
            database.commit()
            cursor.close()

            await ctx.send("Query success : Task %s was deleted."%(title))
        else: await ctx.send("Unknown task %s."%(title))
              
@bot.event
async def on_command_error(ctx, error):
    await reconnectDB()
    if isinstance(error, CommandNotFound):
        unknownCommand = str(error).split(' "')[1].split('"')[0]
        await ctx.send("Unknown command %s. Use !help to see all available commands."%(unknownCommand))
        return
    raise error

bot.run(TOKEN)
