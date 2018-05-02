#!/usr/bin/python
# -*- coding: UTF-8 -*-

import MySQLdb
import requests
import json
import sys
# ?��??�据库�???
db = MySQLdb.connect("localhost", "root", "123456", "web")

# 使用cursor()?��??��??��?游�? 
cursor = db.cursor()

# 使用execute?��??��?SQL语句
#cursor.execute("SELECT videoId FROM video;")

# 使用 fetchone() ?��??��?一?�数??
#videos = cursor.fetchall()
vid = argv[1]
for video in videos:
    print "videoId: %s " % video
    v = "https://www.youtube.com/watch?v=" + str(video[0])
    my_data={"v": v}
    print v
    r = requests.post("http://www.you2json.nctu.me/you2json.php", data=json.dumps(my_data))
    print r.text
    sql = "INSERT INTO subtitle (videoId, subtitles) VALUES (%s, %s)"# % (str(video[0]), json.dumps(r.text))
    print sql
#    print r.json()
    try:
        # Execute the SQL command
        cursor.execute(sql, (str(video[0]), json.dumps(r.content)),)
        # Commit your changes in the database
        db.commit()
    except:
        print("training--------------")
        # Rollback in case there is any error
        db.rollback()

db.close()
