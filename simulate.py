import multiprocessing, requests, json, random, time
from tracemalloc import start
from turtle import st
students = 300 #This is basicly how many subprocesses you want lol
studentsPerRoom = 30
classesPerStudent = 8
roomAmm = students/studentsPerRoom
roomAmm = round(roomAmm)
studentLst = {}
vpHostname = "localhost:8080"
names = requests.get("https://raw.githubusercontent.com/smashew/NameDatabases/master/NamesDatabases/first%20names/us.txt").text.replace("\r", "").split("\n"); names.pop(len(names) - 1)
lnames = requests.get("https://raw.githubusercontent.com/smashew/NameDatabases/master/NamesDatabases/surnames/us.txt").text.replace("\r", "").split("\n"); lnames.pop(len(lnames) - 1)
def convert(seconds):
    seconds = seconds % (24 * 3600)
    hour = seconds // 3600
    seconds %= 3600
    minutes = seconds // 60
    seconds %= 60
      
    return "%d:%02d:%02d" % (hour, minutes, seconds)
def createRooms():
    global studentLst, roomNumbersDct, roomAmm
    login = requests.post("http://" + vpHostname + "/teacher/cklogin.php", data={"uname": "teach", "passwd": "teach"}, allow_redirects=False)
    cookie = ""
    for string in login.headers['set-cookie']:
        cookie += string
    cookieLst = cookie.split("=")
    cookieLst = cookieLst[1].split(";")
    adminKey = cookieLst[0]
    print("Making all rooms...")
    count = 1
    for x in roomNumbersDct:
        print(count, "_of_", roomAmm, end='\r')
        makeRoom = requests.post("http://" + vpHostname + "/teacher/mk_room/regqrid.php?room=" + str(x), allow_redirects=False, headers={"Cookie": "teacher=" + str(adminKey)}, data={"rnum": str(roomNumbersDct[x]['rnum'])})
        count = count+1
    print("\nDONE!")
def makeStudents():
    global students, roomAmm, classesPerStudent, studentLst, roomNumbers, roomNumbersDct
    firstRoom = 100
    roomNumbers = []
    roomNumbersDct = {}
    for number in range(0,roomAmm):
        ident = random.randint(111111111, 999999999)
        roomNumbers.append({"rnum": firstRoom, "id": ident})
        roomNumbersDct[ident] = {"rnum": firstRoom, "id": ident}
        firstRoom = firstRoom+1
    for x in range(0,students):
        tmpRoom = []
        for p in range(0, classesPerStudent):
            tmpRoom.append(random.choice(roomNumbers)['id'])
        studentID = random.randint(11111111111111111111, 99999999999999999999)
        studentLst[str(studentID)] = {
            "fname": random.choice(names),
            "lname": random.choice(lnames),
            "id": random.randint(111111111, 999999999),
            "email": random.choice(names) + "@gmail.com",
            "rooms": tmpRoom
        }
def makeRealStudents():
    global studentLst, roomNumbersDct, studentLstNew, students
    studentLstNew = {}
    print("Making students...")
    count = 1
    for x in studentLst:
        print(count, "_of_", students, end='\r')
        login = requests.post("http://" + vpHostname + "/registercookie.php?room=" + str(studentLst[x]['rooms'][0]) + "&page=main", data={"firstname": studentLst[x]['fname'], "lastname": studentLst[x]['lname'], "stid": studentLst[x]['id'], "stem": studentLst[x]['email']}, allow_redirects=False)
        cookie = ""
        #print(login.text, "\n ", {"firstname": studentLst[x]['fname'], "lastname": studentLst[x]['lname'], "stid": studentLst[x]['id'], "stem": studentLst[x]['email']})
        for string in login.headers['set-cookie']:
            cookie += string
        cookieLst = cookie.split("=")
        cookieLst = cookieLst[1].split(";")
        studentPhid = cookieLst[0]
        studentLstNew[studentPhid] = studentLst[x]
        count = count+1
    print("\nDONE!")
def regStudentWithRoom():
    global studentLst, roomNumbersDct, studentLstNew, students, classesPerStudent
    print("regestering students with their rooms...")
    count = 0
    startTime = 0
    endTime = 0
    tprLst = []
    for x in studentLstNew:
        tpr = endTime - startTime
        tprLst.append(tpr)
        timeLeft = (sum(tprLst)/len(tprLst))*students
        startTime = time.time()
        count = count+1
        print(count, " of ", students, "Seconds per request:", round(sum(tprLst)/len(tprLst)), "Time remaining:", convert(timeLeft), end='\r')
        for y in studentLstNew[x]['rooms']:
            login = requests.get("http://" + vpHostname + "/do_activ.php?room=" + str(y) + "&page=main", headers={"Cookie": "phid=" + str(x)}, allow_redirects=False)
            login = requests.get("http://" + vpHostname + "/do_activ.php?room=" + str(y) + "&page=main", headers={"Cookie": "phid=" + str(x)}, allow_redirects=False)
        endTime = time.time()
    print("\nDone!")

def student(id):
    global studentLstNew, classesPerStudent
    subprocesses = {}
    def studentSim(myId, currentRoom):
        while True:
            time.sleep(random.randint(600, 1800))
            requests.get("http://" + vpHostname + "/do_activ.php?room=" + str(currentRoom) + "&page=main", headers={"Cookie": "phid=" + str(myId)}, allow_redirects=False)
            print(id, "Departed")
            time.sleep(random.randint(180, 600))
            requests.get("http://" + vpHostname + "/do_activ.php?room=" + str(currentRoom) + "&page=main", headers={"Cookie": "phid=" + str(myId)}, allow_redirects=False)
            print(id, "Arrived")
    def switchRoom(subprocesses, timePerRoom, sTime, croom, myId, myRooms, classesPerStudent):
        while True:
            time.sleep(60)
            if (sTime + timePerRoom <= int(time.time())):
                print(myId, "Switch room")
                subprocesses['studentSim'].terminate()
                sTime = int(time.time())
                if (croom >= classesPerStudent):
                    croom = 0
                else:
                    croom = croom+1
                subprocesses['studentSim'] = multiprocessing.Process(target=studentSim, args=(myId, myRooms[croom]))
                subprocesses['studentSim'].start()

    myId = studentLstNew[id]
    myRooms = studentLstNew[id]['rooms']
    timePerRoom = 3600 #an hour
    breakTime = 58800 #16 hours 20 minutes
    startTime = int(time.time())
    croom = 0
    subprocesses['studentSim'] = multiprocessing.Process(target=studentSim, args=(myId, myRooms[croom]))
    subprocesses['switchRoom'] = multiprocessing.Process(target=switchRoom, args=(subprocesses, timePerRoom, startTime, croom, myId, myRooms, classesPerStudent))
    subprocesses['studentSim'].start()
    subprocesses['switchRoom'].start()
def startProcesses():
    global processList, studentLstNew
    processList = {}
    for x in studentLstNew:
        processList[x] = multiprocessing.Process(target=student, args=(x,))
        processList[x].start()
    print("All processes started!")
makeStudents()
createRooms()
makeRealStudents()
regStudentWithRoom()
startProcesses()