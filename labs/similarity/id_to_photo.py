import sys
import os


docindexfile = open( "pgdocindex.txt" );

docindex = []
for line in docindexfile.readlines()[3:-1]:
	line = line.replace('Key: ', '')
	line = line.replace(': Value: /', ' ')	
	line = line.replace('.txt', '')	
	y = [value for value in line.split()]
	docindex.append( y )

docindexfile.close()
print docindex

