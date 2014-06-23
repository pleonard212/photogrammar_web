import sys
import os
import re
# connect to mysql
import MySQLdb
conn = MySQLdb.connect(host = "[HOSTNAME]", user = "[USER]", passwd = "[PASS]", db = "[DATABASE]")
cursor = conn.cursor()
cursor.execute("CREATE TABLE IF NOT EXISTS similarity (`simid` INT( 6 ) NOT NULL AUTO_INCREMENT, `thisphoto` VARCHAR( 13 ) NOT NULL, `similarphoto` VARCHAR( 13 ) NOT NULL, `howsimilar` FLOAT NOT NULL, PRIMARY KEY (  `simid` )) ENGINE = MYISAM DEFAULT CHARSET = utf8;")
cursor.execute("TRUNCATE TABLE similarity;")

def replace_all(text, dic):
  for i, j in dic:
  	if text == i:
	    text = text.replace(i, j)
  return text




docindexfile = open( "pgdocindex.txt" );

docindex = []
for line in docindexfile.readlines()[3:-1]:
	line = line.replace('Key: ', '')
	line = line.replace(': Value: /', ' ')	
	line = line.replace('.txt', '')	
	y = [value for value in line.split()]
	docindex.append( y )

docindexfile.close()
# print docindex


probfile = open(sys.argv[1])
lines = probfile.readlines()[3:-1]
for line in lines[1:]:
	line = line.strip()
	line = line.replace('{', '')
	line = line.replace('}', '')
	line = line.replace('Key: ', '')
	line = line.replace(': Value:', '')
	line = line.replace(':', ' ')
	line = line.replace(',', ' ')
	print line
	parts = line.split(' ')


	thisphoto =  parts[0]
	thisphoto = replace_all(thisphoto, docindex)
	probtuples = []
	probtuple = ()
	for part in parts[1:]:
		if len(probtuple) < 5:
			probtuple += (part,)
		if len(probtuple) == 5:
                	probtuples.append(probtuple)
                	probtuple = ()
	for probtuple in probtuples:
        	similarphoto = (replace_all(probtuple[0], docindex)) 
        	howsimilar = probtuple[1]
                if ((float(howsimilar) > 0.0001) & (float(howsimilar) < 0.9)) :
			sqlargument = "insert into similarity (thisphoto, similarphoto, howsimilar) values (%s, %s, %s)"
                    	cursor.execute(sqlargument, (thisphoto, similarphoto, howsimilar))
                    	print (sqlargument, (thisphoto, similarphoto, howsimilar))