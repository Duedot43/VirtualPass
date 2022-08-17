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
print(names)
def createRooms():
    login = requests.post("http://" + vpHostname + "/teacher/cklogin.php", data={"uname": "teach", "passwd": "teach"}, allow_redirects=False)
    cookie = ""
    for string in login.headers['set-cookie']:
        cookie += string
    cookieLst = cookie.split("=")
    cookieLst = cookieLst[1].split(";")
    adminKey = cookieLst[0]
    makeRoom = requests.post("http://" + vpHostname + "/teacher/mk_room/regqrid.php?room=")
def makeStudents():
    global students, roomAmm, classesPerStudent, studentLst
    firstRoom = 100
    roomNumbers = []
    for number in range(1,roomAmm):
        roomNumbers.append(firstRoom)
        firstRoom = firstRoom+1
    for x in range(1,students):
        studentID = random.randint(11111111111111111111, 99999999999999999999)
        studentLst[str(studentID)] = {
            "fname": "name",
            "lname": "name",
            "id": random.randint(111111111, 999999999),
            "email": "email"
        }
def student(name):
    r = requests.post("http://" + vpHostname + "/index.php?room=")
makeStudents()