#Library Import
from flask import Flask, render_template, request,flash, redirect #Flask micro python server

# import lcddriver #Library LCD 
import time
import board
import busio
from digitalio import DigitalInOut, Direction
import adafruit_fingerprint
import serial
import pymysql
import socket

#Variable Declaration
app = Flask(__name__, template_folder='../Fingerprint') #Server Declaration
# display = lcddriver.Lcd()
uart = serial.Serial("/dev/ttyUSB0", baudrate=57600, timeout=1)
finger = adafruit_fingerprint.Adafruit_Fingerprint(uart)

s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
s.connect(("8.8.8.8", 80))
ip = s.getsockname()[0]
link = "http://" + ip + "/Fingeprint/"
errorLink = link + "Admin/StudentEdit.php?errorFlask="

db = pymysql.connect(
        host='localhost',
        user='root',
        password='sudo',
        db='attendance2')


# display.lcd_display_string("Welcome ", 1)
# display.lcd_display_string("Fingerprint Attendance ", 2)

print("----------------")
if finger.read_templates() != adafruit_fingerprint.OK:
    raise RuntimeError("Failed to read templates")
 
print("Fingerprint templates:", finger.templates)
# display.lcd_display_string("Attendance System: ", 1)

# display.lcd_display_string(str(len(finger.templates))+ " prints", 2)

@app.route('/')
def index():
    return render_template('index.html')
    
@app.route('/enroll')#student face enrollment
def enroll():
    location = request.args.get('uid', default=123, type=int)#GET username from web server/from web system
    print(location)
    import time
    import sys
    # display.lcd_clear()
   
    # display.lcd_display_string("Fingerprint Detection Started", 1)
    # display.lcd_clear()
    # display.lcd_display_string("Your Usr ID : "+ str(location), 1)
    # display.lcd_display_string("Place finger", 2)
    for fingerimg in range(1, 3):
        if fingerimg == 1:
            print("Place finger on sensor...", end="", flush=True)
        else:
            print("Place same finger again...", end="", flush=True)
            # display.lcd_display_string("Place same finger", 2)

        while True:
            i = finger.get_image()
            if i == adafruit_fingerprint.OK:
                print("Image taken")
                break
            if i == adafruit_fingerprint.NOFINGER:
                print(".", end="", flush=True)
            elif i == adafruit_fingerprint.IMAGEFAIL:
                print("Imaging error")
                # display.lcd_display_string("Error 1", 2)
                return redirect(errorLink + "1")
            else:
                print("Other error")
                # display.lcd_display_string("Error 2", 2)
                return redirect(errorLink + "2")

        print("Templating...", end="", flush=True)
        i = finger.image_2_tz(fingerimg)
        if i == adafruit_fingerprint.OK:
            print("Templated")
        else:
            if i == adafruit_fingerprint.IMAGEMESS:
                print("Image too messy")
                #display.lcd_display_string("Error 3", 2)
                return redirect(errorLink + "3")
            elif i == adafruit_fingerprint.FEATUREFAIL:
                print("Could not identify features")
                #display.lcd_display_string("Error 4", 2)
                return redirect(errorLink + "4")
            elif i == adafruit_fingerprint.INVALIDIMAGE:
                print("Image invalid")
                #display.lcd_display_string("Error 5", 2)
                return redirect(errorLink + "5")
            else:
                print("Other error")
                #display.lcd_display_string("Error 6", 2)
                return redirect(errorLink + "6")
            #return False

        if fingerimg == 1:
            print("Remove finger")
            #display.lcd_display_string("Remove finger", 2)
            time.sleep(1)
            while i != adafruit_fingerprint.NOFINGER:
                i = finger.get_image()

    print("Creating model...", end="", flush=True)
    i = finger.create_model()
    if i == adafruit_fingerprint.OK:
        print("Created")
    else:
        if i == adafruit_fingerprint.ENROLLMISMATCH:
            print("Prints did not match")
            return redirect(errorLink + "7")
        else:
            print("Other error")
            return redirect(errorLink + "6")
        #flash('Looks like you have changed your name!')

    print("Storing model #%d..." % location, end="", flush=True)
    i = finger.store_model(location)
    if i == adafruit_fingerprint.OK:
        cursor = db.cursor()
        
        try:
            # Execute the SQL command
            cursor.execute("UPDATE student SET enrol_fingerprint =1 WHERE id=%d" % location)
            
            print(cursor.rowcount, "Default record(s) updated")
            # Commit your changes in the database
            print("Sucess")
            db.commit()
        except:
            # Rollback in case there is any error
            print("error")
            db.rollback()
        print("Stored")
        
    else:
        if i == adafruit_fingerprint.BADLOCATION:
            print("Bad storage location")
            return redirect(errorLink + "8")
        elif i == adafruit_fingerprint.FLASHERR:
            print("Flash storage error")
            return redirect(errorLink + "9")
        else:
            print("Other error")
            return redirect(errorLink + "2")
        #return False
    #display.lcd_clear()
    #display.lcd_display_string("Capture Success ", 1)
    return redirect(link + "Admin/Student.php")

def get_fingerprint():
    """Get a finger print image, template it, and see if it matches!"""
    # display.lcd_display_string("Fingerprint Detect Started", 1)
    # display.lcd_display_string("Waiting for image...", 2)
    print("Waiting for image...")
    #display.lcd_clear()
    #display.lcd_display_string("Attendance Taking ", 1)
   
    while finger.get_image() != adafruit_fingerprint.OK:
        pass
    print("Templating...")
    if finger.image_2_tz(1) != adafruit_fingerprint.OK:
        return False
    print("Searching...")
    if finger.finger_search() != adafruit_fingerprint.OK:
        return False
    return True

@app.route('/attendance')#attendance taking
def attendance():
    classID = request.args.get('cID', default=0, type=int)
    stop = request.args.get('stop', default=0, type=int)
    #import os
    #import pickle
    import time
    from datetime import datetime
    
    date = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    timeout = time.time() + 60*5
    
    try:
        while True:
            if get_fingerprint():
                #print("Detected #", finger.finger_id, "with confidence", finger.confidence)
                if(finger.confidence >150):
                    name = finger.finger_id
                    print(name)
                    cursor = db.cursor()
                    sql2 = "SELECT student_has_exam.*, student.name FROM student_has_exam INNER JOIN student ON student.id = student_has_exam.student_id WHERE student_has_exam.student_id = '%d' AND student_has_exam.exam_id = '%d'" % (name, classID)
                    try:
                        print(sql2)
                        cursor.execute(sql2)
                        if(cursor.rowcount>0):
                            row = cursor.fetchone()
                            sql = "UPDATE student_has_exam SET attendance = 1, attendance_date_time = '%s' WHERE id = '%d'" % (date, row[0])
                            print("Attended :",sql)
                            try:
                                cursor.execute(sql)
                                print(cursor.rowcount, "record(s) affected")
                                db.commit()
                            except:
                                db.rollback()
                            db.commit()
                    except:
                        db.rollback()
                    print("Detected #", finger.finger_id, "with confidence", finger.confidence)
                    #display.lcd_display_string("Attendance :", 1)
                    #display.lcd_display_string(str(finger.finger_id), 2)
            else:
                cursor = db.cursor()
                sql3 = "SELECT * FROM student_has_exam WHERE exam_id = '%d'" % (classID)
                try:
                    cursor.execute(sql3)
                    # print(cursor.rowcount, "Total updated")
                    # Commit your changes in the database
                    #display.lcd_display_string(str(cursor.rowcount)+" Attended ", 2)
                    # print("Count Sucess")
                    db.commit()
                except:
                    # Rollback in case there is any error
                    print("Counterror")
                    db.rollback()
                print("Finger not found")
    except (stop == 1):
        print('interrupted!')
    return redirect(link + "Lecturer/Menu.php")

@app.route('/delete')#attendance taking
def delete():
    location = request.args.get('uid', default=123, type=int)#GET username from web server/from web system
    if finger.delete_model(location) == adafruit_fingerprint.OK:
        print("Deleted!")
        print(location)
    else:
        print("Failed to delete")
    #display.lcd_display_string(str(len(finger.templates))+ " prints", 2)
    return redirect(link + "Admin/Student.php")

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0')

