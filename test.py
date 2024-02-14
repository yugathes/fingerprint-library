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
import Adafruit_GPIO.SPI as SPI
import Adafruit_SSD1306
from PIL import Image
from PIL import ImageDraw
from PIL import ImageFont

#Variable Declaration
app = Flask(__name__, template_folder='../Fingerprint') #Server Declaration
# display = lcddriver.Lcd()
#uart = serial.Serial("/dev/ttyUSB0", baudrate=57600, timeout=1)
uart = serial.Serial("/dev/ttyS0", baudrate=57600, timeout=1)
finger = adafruit_fingerprint.Adafruit_Fingerprint(uart)

RST = 24
DC = 23
SPI_PORT = 0
SPI_DEVICE = 0

s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
s.connect(("8.8.8.8", 80))
ip = s.getsockname()[0]
#Declare your browser directory here
link = "http://" + ip + "/Fingerprint/"
errorLink = link + "Admin/UsersEdit.php?errorFlask="

db = pymysql.connect(
        host='localhost',
        user='root',
        password='sudo',
        db='library')


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
    userName = get_username(location)
    if(userName != "NULL"):
        print(userName)
        display_enroll(userName)
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
            cursor.execute("UPDATE users SET fingerprint =1 WHERE id=%d" % location)
            
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
    return redirect(link + "Admin/Users.php")

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
    #import os
    #import pickle
    stop = 0
    from datetime import datetime
    
    while True:
        display_system_ready()
        now = datetime.now()
        today = now.strftime("%Y-%m-%d")
        if get_fingerprint():
            #print("Detected #", finger.finger_id, "with confidence", finger.confidence)
            if(finger.confidence >50):
                name = finger.finger_id
                print("Detected #", finger.finger_id, "with confidence", finger.confidence)
                cursor = db.cursor()
                sql2 = "SELECT * FROM attendance WHERE user_id = '%d' AND date = '%s'" % (name, today)
                try:
                    cursor.execute(sql2 + " AND ABS(TIMESTAMPDIFF(MINUTE, time, CURRENT_TIMESTAMP())) <= 5")                                    
                    if(cursor.rowcount<1):
                        sql = "INSERT INTO attendance (user_id, date, time) VALUES (%d, '%s', CURRENT_TIME())" % (name, today)
                        print("Attended :",name)
                        try:
                            cursor.execute(sql)
                            display_detected(get_username(name))
                            print(cursor.rowcount, "record(s) affected")
                            db.commit()
                        except:
                            db.rollback()
                        db.commit()
                    else:
                        print("You already attend.Please enter after 5 mins")
                        display_duplicate()
                except:
                    db.rollback()
                #display.lcd_display_string("Attendance :", 1)
                #display.lcd_display_string(str(finger.finger_id), 2)
        else:
            # cursor = db.cursor()
            # sql3 = "SELECT * FROM student_has_exam WHERE exam_id = '%d'" % (classID)
            # try:
                # cursor.execute(sql3)
                # # print(cursor.rowcount, "Total updated")
                # # Commit your changes in the database
                # #display.lcd_display_string(str(cursor.rowcount)+" Attended ", 2)
                # # print("Count Sucess")
                # db.commit()
            # except:
                # # Rollback in case there is any error
                # print("Counterror")
                # db.rollback()
            print("Finger not found")
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
    return redirect(link + "Admin/Users.php")

def display_enroll(name):
    # Initialize library and display
    disp = Adafruit_SSD1306.SSD1306_128_32(rst=RST)

    # Initialize display.
    disp.begin()

    # Clear display.
    disp.clear()
    disp.display()

    # Create blank image for drawing.
    width = disp.width
    height = disp.height
    image = Image.new('1', (width, height))

    # Get drawing object to draw on image.
    draw = ImageDraw.Draw(image)

    # Load default font.
    font = ImageFont.load_default()

    # Display welcome message
    draw.rectangle((0, 0, width, height), outline=0, fill=0)

    # Display ID
    draw.text((5, 5), "ID : " + name, font=font, fill=255)

    # Display instruction
    draw.text((5, 20), "Place your fingers", font=font, fill=255)

    # Display image.
    disp.image(image)
    disp.display()
    
def display_on_oled():
    disp = Adafruit_SSD1306.SSD1306_128_32(rst=RST)
    disp.begin()
    disp.clear()
    disp.display()
    
    width = disp.width
    height = disp.height
    image = Image.new('1', (width, height))
    draw = ImageDraw.Draw(image)
    font = ImageFont.load_default()
    
    text_lines = ["Welcome", "To", "Library Log"]
    
    y_start = 0  # Adjusted starting position
    
    for line in text_lines:
        text_width, text_height = draw.textsize(line, font=font)
        x = (width - text_width) // 2
        draw.text((x, y_start), line, font=font, fill=255)
        y_start += text_height  # Move to the next line
    
    disp.image(image)
    disp.display()

def get_username(id):
    try:
        cursor = db.cursor()
        sql = "SELECT local_id FROM users WHERE id = %s" % id
        cursor.execute(sql)
        result = cursor.fetchone()
        if result:
            return result[0]  # Return the user's name
        else:
            return "NULL"
    except Exception as e:
        return str(e)
    finally:
        cursor.close()

def display_system_ready():
    disp = Adafruit_SSD1306.SSD1306_128_32(rst=RST)
    disp.begin()
    disp.clear()
    disp.display()
    
    width = disp.width
    height = disp.height
    image = Image.new('1', (width, height))
    draw = ImageDraw.Draw(image)
    font = ImageFont.load_default()
    
    text1 = "System Ready"
    text2 = "Place your Finger"
    
    # Get size for the first text
    text1_width, text1_height = draw.textsize(text1, font=font)
    # Calculate position for the first text
    x1 = (width - text1_width) // 2
    y1 = (height - text1_height) // 2 - 10  # Move up
    
    # Get size for the second text
    text2_width, text2_height = draw.textsize(text2, font=font)
    # Calculate position for the second text
    x2 = (width - text2_width) // 2
    y2 = (height - text2_height) // 2 + 10  # Move down
    
    # Display first text
    draw.text((x1, y1), text1, font=font, fill=255)
    # Display second text
    draw.text((x2, y2), text2, font=font, fill=255)
    
    disp.image(image)
    disp.display()
    
def display_detected(id_text):
    disp = Adafruit_SSD1306.SSD1306_128_32(rst=RST)
    disp.begin()
    disp.clear()
    disp.display()
    
    width = disp.width
    height = disp.height
    image = Image.new('1', (width, height))
    draw = ImageDraw.Draw(image)
    font = ImageFont.load_default()
    
    # Display "Detected" in the middle
    text = "Detected"
    text_width, text_height = draw.textsize(text, font=font)
    x = (width - text_width) // 2
    y = (height - text_height) // 2 - 10  # Move up to make space for the ID
    draw.text((x, y), text, font=font, fill=255)
    
    # Display the ID below "Detected"
    id_text = "ID : " + id_text
    id_text_width, id_text_height = draw.textsize(id_text, font=font)
    x_id = (width - id_text_width) // 2
    y_id = (height - id_text_height) // 2 + 10  # Move down to display below "Detected"
    draw.text((x_id, y_id), id_text, font=font, fill=255)
    
    disp.image(image)
    disp.display()
    time.sleep(5)

def display_duplicate():
    disp = Adafruit_SSD1306.SSD1306_128_32(rst=RST)
    disp.begin()
    disp.clear()
    disp.display()
    
    width = disp.width
    height = disp.height
    image = Image.new('1', (width, height))
    draw = ImageDraw.Draw(image)
    font = ImageFont.load_default()
    
    text1 = "You already entered"
    text2 = "Enter after 5 mins"
    
    # Get size for the first text
    text1_width, text1_height = draw.textsize(text1, font=font)
    # Calculate position for the first text
    x1 = (width - text1_width) // 2
    y1 = (height - text1_height) // 2 - 10  # Move up
    
    # Get size for the second text
    text2_width, text2_height = draw.textsize(text2, font=font)
    # Calculate position for the second text
    x2 = (width - text2_width) // 2
    y2 = (height - text2_height) // 2 + 10  # Move down
    
    # Display first text
    draw.text((x1, y1), text1, font=font, fill=255)
    # Display second text
    draw.text((x2, y2), text2, font=font, fill=255)
    
    disp.image(image)
    disp.display()
    time.sleep(5)
    
display_on_oled()
if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0')

