import multiprocessing, requests, json
students = 3000
studentsPerRoom = 20
ClassesPerStudent = 8
rooms = students/studentsPerRoom
vpHostname = "localhost:8080"
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
    global students, rooms, ClassesPerStudent

def student(name):
    r = requests.post("http://" + vpHostname + "/index.php?room=")
createRooms()