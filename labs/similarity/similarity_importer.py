import sys
import os
import re
# connect to mysql
import MySQLdb
conn = MySQLdb.connect(host = "127.0.0.1", user = "root", db = "pgtemp")
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
	# print line
	parts = line.split(' ')


	thisphoto =  parts[0]
	thisphoto = replace_all(thisphoto, docindex)
	probtuples = []
	probtuple = ()
	for part in parts[0:]:
		# print probtuple
		if len(probtuple) < 2:
			probtuple += (part,)
			# print probtuple
		if len(probtuple) == 2:
					probtuples.append(probtuple)
					probtuple = ()
	for probtuple in probtuples:
			similarphoto = (replace_all(probtuple[0], docindex))
			howsimilar = probtuple[1]
			if ((float(howsimilar) > 0.0001) & (float(howsimilar) < 0.9)) :
				sqlargument = "insert into similarity (thisphoto, similarphoto, howsimilar) values (%s, %s, %s)"
				print (sqlargument, (thisphoto, similarphoto, howsimilar))
				cursor.execute(sqlargument, (thisphoto, similarphoto, howsimilar))
	
