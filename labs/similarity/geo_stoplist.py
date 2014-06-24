import csv
import string

with open('query_result.csv', 'rb') as csvfile:
	itemreader = csv.reader(csvfile, delimiter=',', quotechar='"')
	for row in itemreader:
		# Older versions of state abbreviations are often present:
		bonusstoplist = ['County']
		if (row[3] == "Alabama"):
			bonusstoplist.extend(['Ala'])
		if (row[3] == "Alaska"):
			bonusstoplist.extend(['Borough'])
		if (row[3] == "Arizona"):
			bonusstoplist.extend(['Ariz'])
		if (row[3] == "Arkansas"):
			bonusstoplist.extend(['Ark'])
		if (row[3] == "California"):
			bonusstoplist.extend(['Cal', 'Calif'])
		if (row[3] == "Colorado"):
			bonusstoplist.extend(['Colo', 'Col'])
		if (row[3] == "Connecticut"):
			bonusstoplist.extend(['Ct', 'Conn'])
		if (row[3] == "Delaware"):
			bonusstoplist.extend(['De', 'Del'])
		if (row[3] == "District of Columbia"):
			bonusstoplist.extend(['DC', 'Washington', 'D', 'C'])
		if (row[3] == "Florida"):
			bonusstoplist.extend(['Fla'])
		if (row[3] == "Georgia"):
			bonusstoplist.extend(['Ga'])
		if (row[3] == "Hawaii"):
			bonusstoplist.extend(['Ha', 'Haw'])
		if (row[3] == "Idaho"):
			bonusstoplist.extend(['Ida'])
		if (row[3] == "Illinois"):
			bonusstoplist.extend(['Ill', 'Il'])
		if (row[3] == "Indiana"):
			bonusstoplist.extend(['Ind', 'Ia'])
		if (row[3] == "Kansas"):
			bonusstoplist.extend(['Kans'])
		if (row[3] == "Kentucky"):
			bonusstoplist.extend(['Ky'])
		if (row[3] == "Louisiana"):
			bonusstoplist.extend(['Parish','La'])			
		if (row[3] == "Maine"):
			bonusstoplist.extend(['Me'])
		if (row[3] == "Maryland"):
			bonusstoplist.extend(['Md'])
		if (row[3] == "Massachusetts"):
			bonusstoplist.extend(['Ms', 'Mass', 'Ma'])
		if (row[3] == "Michigan"):
			bonusstoplist.extend(['Mich', 'Mi'])
		if (row[3] == "Minnesota"):
			bonusstoplist.extend(['Minn', 'Mn'])
		if (row[3] == "Mississippi"):
			bonusstoplist.extend(['Mi', 'Miss'])
		if (row[3] == "Missouri"):
			bonusstoplist.extend(['Mo'])
		if (row[3] == "Montana"):
			bonusstoplist.extend(['Mont'])
		if (row[3] == "Nebraska"):
			bonusstoplist.extend(['Nebr', 'Neb'])
		if (row[3] == "Nevada"):
			bonusstoplist.extend(['Nev'])
		if (row[3] == "New Hampshire"):
			bonusstoplist.extend(['N', 'H', 'NH'])
		if (row[3] == "New Jersey"):
			bonusstoplist.extend(['N', 'J', 'NJ'])
		if (row[3] == "New Mexico"):
			bonusstoplist.extend(['N', 'Mex', 'NM'])
		if (row[3] == "New York"):
			bonusstoplist.extend(['N', 'Y', 'NY'])
		if (row[3] == "North Carolina"):
			bonusstoplist.extend(['N', 'C', 'NC'])
		if (row[3] == "North Dakota"):
			bonusstoplist.extend(['N', 'D', 'Dak', 'ND'])
		if (row[3] == "Ohio"):
			bonusstoplist.extend(['Oh'])
		if (row[3] == "Oklahoma"):
			bonusstoplist.extend(['Okla', 'Ok'])
		if (row[3] == "Oregon"):
			bonusstoplist.extend(['Oreg','Ore'])
		if (row[3] == "Pennsylvania"):
			bonusstoplist.extend(['Pa'])
		if (row[3] == "Rhode Island"):
			bonusstoplist.extend(['R', 'I', 'RI'])
		if (row[3] == "South Carolina"):
			bonusstoplist.extend(['S', 'C', 'SC'])
		if (row[3] == "Tennessee"):
			bonusstoplist.extend(['Te','Tenn','TN'])
		if (row[3] == "Texas"):
			bonusstoplist.extend(['Texas'])
		if (row[3] == "Utah"):
			bonusstoplist.extend(['Ut'])
		if (row[3] == "Vermont"):
			bonusstoplist.extend(['Vt'])
		if (row[3] == "Virginia"):
			bonusstoplist.extend(['Va'])
		if (row[3] == "Washington"):
			bonusstoplist.extend(['Wash', 'WA'])
		if (row[3] == "West Virginia"):
			bonusstoplist.extend(['W', 'V', 'Va', 'WV'])
		if (row[3] == "Wisconsin"):
			bonusstoplist.extend(['Wis'])
		if (row[3] == "Wyoming"):
			bonusstoplist.extend(['Wyo'])
		# For counties and parishes that start with 'St', make sure we also delete 'Saint':
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
