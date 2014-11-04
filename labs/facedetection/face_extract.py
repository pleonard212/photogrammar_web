#Expects a directory with multiple images and one metadata.csv file.
#Returns a subdirectory full of cropped faces, including multiple faces per image.
import pandas
from wand.image import Image
from wand.display import display
metadata = pandas.read_csv('metadata.csv')
for idx, row in metadata.iterrows():
	print "Now saving a face from " + row["File"] + " as " + str(idx) + ".jpg"
	with Image(filename=row["File"]) as img:
		with img.clone() as i:
			i.crop(row["FrontalFace_X"],row["FrontalFace_Y"],width=row["FrontalFace_Width"],height=row["FrontalFace_Height"])
			i.save(filename="facethumbs/"+(str(idx)+".jpg"))
