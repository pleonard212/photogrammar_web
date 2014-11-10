#Expects a directory with multiple images and one metadata.csv file.
#Returns a subdirectory full of cropped faces, including multiple faces per image.
import pandas
from wand.image import Image
#from wand.display import display
import os.path
import sys
counter = 0
metadata = pandas.read_csv('photolists/'+sys.argv[1]+'-faces.csv')
for idx, row in metadata.iterrows():

	with Image(filename='photolists/' + sys.argv[1] + '/' + row["File"]) as img:
		
		with img.clone() as i:
			
			i.crop(row["FrontalFace_X"],row["FrontalFace_Y"],width=row["FrontalFace_Width"],height=row["FrontalFace_Height"])
			print(("facethumbs/"+ os.path.splitext(row["File"])[0] + "_" + str(counter) +  ".jpg"))
			if(os.path.isfile("facethumbs/"+ os.path.splitext(row["File"])[0] + "_"  + str(counter) +  ".jpg")):
				counter += 1
				print("Multiple faces in image " + row["File"])
			else:
				counter = 0
			print "Now saving a face from " + row["File"] + " as " + "facethumbs/" + os.path.splitext(row["File"])[0] + "_" + str(counter)  +  ".jpg"
			i.save(filename="facethumbs/"+os.path.splitext(row["File"])[0] + "_" + str(counter) + ".jpg")
