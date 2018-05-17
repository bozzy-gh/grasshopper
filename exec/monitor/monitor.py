#!/usr/bin/python
#/var/www/exec/monitor
# -*- coding: utf-8 -*-

import sys
import os
import subprocess
import sqlite3
import datetime
import ownGateway

dbfile    = "/var/www/db/grasshopper.sqlite"
logfolder = "/var/log/grasshopper"

recipient = "some.address@email.com"

def db_connect_and_update(group,address,addressstatus,general,ownframe):
    try:
        con = sqlite3.connect(dbfile)
        cur = con.cursor()
        if general:
            cur.execute("UPDATE pointstatus SET status=" + addressstatus + " WHERE btgroup=" + group)
        else:
            cur.execute("INSERT OR REPLACE INTO pointstatus (btgroup, btaddress, status, timestp, ownframe) VALUES (" + group + ", '" + address + "', '" + addressstatus + "', strftime('%Y-%m-%d %H:%M:%f', 'now'), '" + ownframe + "')")
        con.commit()
    except:
        write_to_log("Unexpected error in db_connect_and_update")
    finally:
        if con:
            con.close()

def send_mail(subject,body):
    process = subprocess.Popen(['mail', '-s', subject, recipient],
                               stdin=subprocess.PIPE)
    process.communicate(body)

def write_to_log(message):
    try:
        filename1 = datetime.datetime.now().strftime("%Y%m%d") + "_domotica.log"
        fh = open(logfolder + filename1,"a")
        message = datetime.datetime.now().strftime('%d/%m/%Y %H:%M:%S') + "   " + message + "\r\n"
        fh.write(message)
        #print(message)
    except:
        print("Unexpected error in write_to_log")
    finally:
        fh.close()

def monitor():
    try:
        dbdir = os.path.dirname(dbfile)
        if not os.path.exists(dbdir):
            os.makedirs(dbdir)
        con = sqlite3.connect(dbfile)
        cur = con.cursor()
        cur.execute("DROP TABLE IF EXISTS pointstatus")
        con.commit()
        cur.execute("CREATE TABLE pointstatus (btgroup INT, btaddress TEXT, status TEXT, timestp DATETIME, ownframe TEXT, PRIMARY KEY (btgroup, btaddress))")
        con.commit()
    except:
        write_to_log("Unexpected error in db create")
    finally:
        if con:
            con.close()
    # Connect to gateway in MONITOR mode.
    smon = ownGateway.Connect(ownGateway.MONITOR)
    if smon is None:
        raise Exception("Unable to connect to gateway in Monitor mode!")
    try:
        # Connect to gateway in COMMAND mode.
        scmd = ownGateway.Connect(ownGateway.COMMANDS)
        if scmd is None:
            raise Exception("Unable to connect to gateway in Command mode!")
        try:
            ownGateway.SendData(scmd, "*#1*0##")
        finally:
            ownGateway.Disconnect(scmd)
        # Start monitoring cycle
        data = ""
        while 1:
            next = ownGateway.RecData(smon)  # now read data from MyHome BUS
            if next == "":
                break               # EOF
            data = data + next
            while 1:
                eom = data.find("##")
                if eom < 0:
                    #write_to_log("there is no valid message in the queue, waiting for other messages. queue: " + data)
                    break;           # Not a complete message, need more
                #write_to_log("there are messages in the queue: " + data)
                if data[0] != "*":
                    #write_to_log("NOT VALID: NO *, I'll throw it away until next ##: " + data)
                    data = data[eom+2:]
                    #write_to_log("CONTINUE with: " + data)
                    continue;
                msg = data[0:eom+2]     # message is from position 0 until end of ##
                data = data[eom+2:]     # next message starts after ##
                #write_to_log("I am processing the next event: " +msg + " from the queue.")
                if (msg[0:3] == "*1*") or (msg[0:3] == "*2*"):   # this is a lighting or automation event; check whether to update the database or not.
                    if msg[0:8] == "*1*0*0##": #All off command
                        #write_to_log("all off: " + msg)
                        address = "0"
                        addressstatus = "0"
                        db_connect_and_update("1",address,addressstatus,True,"")
                    elif msg[0:8] == "*1*1*0##": #All on command
                        #write_to_log("all on: " + msg)
                        address = "0"
                        addressstatus = "1" #dimmers will not have the correct value!
                        db_connect_and_update("1",address,addressstatus,True,"")
                    else:
                        #write_to_log("This is not an all-off event, processing as real message ")
                        if msg[0:8] != "*1*1000#": #ignore this event, it is a dimmer value change from a bticino button"
                            msg1 = msg[3:]
                            addressstatus = msg1[0:msg1.find("*")]
                            address = msg1[len(addressstatus)+1:msg1.find("##")]
                            #write_to_log(msg + " / lighting event: address " + address + " is set to value " + addressstatus)
                            db_connect_and_update(msg[1:2],address,addressstatus,False,msg + " (next: " + data + ")")
                            #write_to_log("SUCCESS! Processed. Now continuing with: " + data)
                            continue
                else:
                    #write_to_log("NOT VALID: doesn't start with *1* or *2*: " + msg)
                    #write_to_log("CONTINUE with: " + data)
                    continue
    except:
        write_to_log("Unexpected error in monitor")
    finally:
        ownGateway.Disconnect(smon)
        sys.exit()


if __name__=='__main__':
    monitor()                           # start the monitor
