#!/bin/bash
SERVER=http://localhost:9200
INDEX=megacorp
TYPE=employee
URL=${SERVER}/megacorp/employee

curl -i -XPUT ${URL}/1 -d'{
    "first_name" : "John",
    "last_name" :  "Smith",
    "age" :        25,
    "about" :      "I love to go rock climbing",
    "interests": [ "sports", "music" ]
}'

curl -i -XPUT ${URL}/2 -d'{
   "first_name" :  "Jane",
    "last_name" :   "Smith",
    "age" :         32,
    "about" :       "I like to collect rock albums",
    "interests":  [ "music" ]
}'

curl -i -XPUT ${URL}/3 -d'{
    "first_name" :  "Douglas",
    "last_name" :   "Fir",
    "age" :         35,
    "about":        "I like to build cabinets",
    "interests":  [ "forestry" ]
}'


