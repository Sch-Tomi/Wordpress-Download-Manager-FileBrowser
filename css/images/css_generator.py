#!/usr/bin/python

from os import listdir
from os.path import isfile, join

temp = open("tmp.css","w")

for f in listdir("./"):
    if isfile(join("./", f)) and f != "folder.png" and f != "css_generator.py":
        ext = f.split(".")[0].replace("_","")
        temp.write("""div.ext_"""+ext+""" {
    background: rgba(0, 0, 0, 0) url(\"images/"""+f+"""\") no-repeat scroll left top;
    float: left;
    height: 32px;
    width: 32px;
}\n\n""")

temp.close()
