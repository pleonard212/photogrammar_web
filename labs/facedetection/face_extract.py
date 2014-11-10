# Expects a directory with multiple images ("photolists/johncollier") and one metadata file ("photolists/johncollier-faces.csv")
# Usage: python face_extract.py johncollier
# Returns a subdirectory full of cropped faces in photofaces/ .
# If more than one face is found in an image, serialize the cropped faces as <cnumber>_0.jpg, <cnumber>_01.jpg, etc.
import pandas
# We need pandas to process large CSV files quickly
from wand.image import Image
# Wand is a python binding for imagemagick, which we use to crop faces. http://docs.wand-py.org/en/0.3.8/
import os.path
# We use path to test if multiple facess are pulled from one image.
# NB: If you are re-running this script multiple times on the same csv, be sure to delete all the images the facethumbs/ dir,
# otherwise the faces will continue to iterate and create duplicatres.
import sys
# We use sys to grab the name of the photographer from the command-line
metadata = pandas.read_csv('photolists/'+sys.argv[1]+'-faces.csv')
# Read the list of found faces from photolists/johncollier-faces.csv
counter = 0
# Start the face counter at 0

for idx, row in metadata.iterrows():
# Take each row in photolists/john-collier-faces.csv and...
	with Image(filename='photolists/' + sys.argv[1] + '/' + row["File"]) as img:
	# ...grab the jpg file from photolists/johncollier/cnumber.jpg...
		with img.clone() as i:
		# ...create a clone of it...
			i.crop(row["FrontalFace_X"],row["FrontalFace_Y"],width=row["FrontalFace_Width"],height=row["FrontalFace_Height"])
			# ...crop that new image according to the bounding box of the current face from the csv file...
			if(os.path.isfile("facethumbs/"+ os.path.splitext(row["File"])[0] + "_"  + str(counter) +  ".jpg")):
			# ...test if there is already a file that ends in "_0.jpg" 
				counter += 1
				# - if so, a face has already been found in this pic and we need to make the suffix _01.jpg or _02.jpg, etc.
				print("Multiple faces in image " + row["File"])
				# Tell the user this
			else:
			# if there isn't an _0.jpg already, 
				counter = 0
				# then this is the first face found and it should be named _0.jpg
			print "Now saving a face from " + row["File"] + " as " + "facethumbs/" + os.path.splitext(row["File"])[0] + "_" + str(counter)  +  ".jpg"
			# Tell the user which image the face is from and what the saved file name is.
			i.save(filename="facethumbs/"+os.path.splitext(row["File"])[0] + "_" + str(counter) + ".jpg")
			# Save the cropped face file to the facethumbs directory.