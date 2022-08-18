import multiprocessing, requests, json, random
from more_itertools import first
students = 3000
studentsPerRoom = 20
classesPerStudent = 8
roomAmm = students/studentsPerRoom
roomAmm = round(roomAmm)
studentLst = {}
vpHostname = "localhost:8080"
names = requests.get("https://raw.githubusercontent.com/smashew/NameDatabases/master/NamesDatabases/first%20names/us.txt").text.replace("\r", "").split("\n")
lnames = requests.get("https://raw.githubusercontent.com/smashew/NameDatabases/master/NamesDatabases/surnames/all.txt").text.replace("\r", "").split("\n")
def createRooms():
    global studentLst, roomNumbersDct
    login = requests.post("http://" + vpHostname + "/teacher/cklogin.php", data={"uname": "teach", "passwd": "teach"}, allow_redirects=False)
    cookie = ""
    for string in login.headers['set-cookie']:
        cookie += string
    cookieLst = cookie.split("=")
    cookieLst = cookieLst[1].split(";")
    adminKey = cookieLst[0]
    print("Making all rooms...")
    for x in studentLst:
        for y in studentLst[x]['rooms']:
            makeRoom = requests.post("http://" + vpHostname + "/teacher/mk_room/regqrid.php?room=" + str(y), allow_redirects=False, headers={"Cookie": "teacher=" + str(adminKey)}, data={"rnum": str(roomNumbersDct[y]['rnum'])})
def makeStudents():
    global students, roomAmm, classesPerStudent, studentLst, roomNumbers, roomNumbersDct
    firstRoom = 100
    roomNumbers = []
    roomNumbersDct = {}
    for number in range(1,roomAmm):
        ident = random.randint(111111111, 999999999)
        roomNumbers.append({"rnum": firstRoom, "id": ident})
        roomNumbersDct[ident] = {"rnum": firstRoom, "id": ident}
        firstRoom = firstRoom+1
    for x in range(1,students):
        tmpRoom = []
        for p in range(1, classesPerStudent):
            tmpRoom.append(random.choice(roomNumbers)['id'])
        studentID = random.randint(11111111111111111111, 99999999999999999999)
        studentLst[str(studentID)] = {
            "fname": random.choice(names),
            "lname": random.choice(lnames),
            "id": random.randint(111111111, 999999999),
            "email": random.choice(names) + "@gmail.com",
            "rooms": tmpRoom
        }
def student(name):
    r = requests.post("http://" + vpHostname + "/index.php?room=")
makeStudents()
createRooms()