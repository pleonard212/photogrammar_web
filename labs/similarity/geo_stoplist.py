from __future__ import print_function	
import csv
import string

with open('query_result.csv', 'rb') as csvfile:
	itemreader = csv.reader(csvfile, delimiter=',', quotechar='"')
	for row in itemreader:
		bonusstoplist = ['County']
		if (row[3] == "Louisiana"):
			bonusstoplist.append('Parish')
		if (row[3] == "District of Columbia"):
			bonusstoplist.append('DC')
		if (row[2].startswith("St ")):
			bonusstoplist.append('Saint')
		statestoplist = row[3].split()
		countystoplist =  row[2].split()
		citystoplist = row[1].split()
		mergedstoplist = statestoplist + countystoplist + citystoplist + bonusstoplist
		descriptionwithpunctuation = row[4].translate(string.maketrans(" "," "), string.punctuation)
		descriptionnopunctuation =  descriptionwithpunctuation.split()
		print("Remove \"" + ' '.join(mergedstoplist) + "\" from \""  + descriptionwithpunctuation + "\"")
		filtered_words = [w for w in descriptionnopunctuation if not w in mergedstoplist]
		print("The result is: " + ' '.join(filtered_words))
		print("\n")
		file = open(('output/'+row[0].replace('/PP','')+ ".txt"), "w")
		file.write(' '.join(filtered_words))

