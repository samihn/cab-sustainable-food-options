
# Script to read in data from 4 files and then write them into 4 tables in our database

#! /usr/bin/python2

import psycopg2
from config import config
 
if __name__ == '__main__':
	# Iniatlize connection
	conn = None
    # read connection parameters
	params = config()

    # connect to the PostgreSQL server
	print('Connecting to the %s database...' % params['database'])
	conn = psycopg2.connect(**params)
	print('Connected.\n')
	conn.autocommit = True
  
	# create a cursor
	cur = conn.cursor()

	print('Loading in town data...')

	# Open file with town data
	f = open("town.txt")

	# Go through line by line
	for y in f:
		# Format and get each part of the line
		x = (y.split('; '))
		one = str(x[0].strip())
		two = str(x[1].strip())
		three = str(x[2].strip())
		four = str(x[3].strip())
		# Insert into town table in form of a psql query
		cur.execute("INSERT INTO TOWN VALUES('%s', '%s', '%s', '%s');" %(one, two, three, four))
	# Close file
	f.close()

	print('Loading in restaurant data...')

	# Open file with restaurants data
	f = open("restaurants.txt")

	# Go through line by line
	for y in f:
		# Format and get each part of the line
		x = (y.split('; '))
		one = str(x[0].strip())
		two = str(x[1].strip())
		three = str(x[2].strip())
		four = str(x[3].strip())
		five = str(x[4].strip())
		# Insert into restaurant table in form of a psql query
		cur.execute("INSERT INTO RESTAURANT VALUES('%s', '%s', '%s', '%s', '%s');" %(one, two, three, four, five))
	# Close file
	f.close()

	print('Loading in vegan options data...')

	# Open file with vegan options data
	f = open("vegan_options.txt")

	# Go through line by line
	for y in f:
		# Format and get each part of the line
		x = (y.split('; '))
		one = str(x[0].strip())
		two = str(x[1].strip())
		# Insert into vegan options table in form of a psql query
		cur.execute("INSERT INTO VEGAN_OPTIONS VALUES('%s', '%s');" %(one, two))
	# Close file
	f.close()

	print('Loading in sustainability data...')

	# Open file with sustainability data
	f = open("sustainability.txt")

	# Go through line by line
	for y in f:
		# Format and get each part of the line
		x = (y.split('; '))
		one = str(x[0].strip())
		two = str(x[1].strip())
		three = str(x[2].strip())
		four = str(x[3].strip())
		five = str(x[4].strip())
		# Insert into sustainability table in form of a psql query
		cur.execute("INSERT INTO SUSTAINABILITY VALUES('%s', '%s', '%s', '%s', '%s');" %(one, two, three, four, five))
	# Close file
	f.close()

	print('All data succesfully loaded and inserted.')

	# Close connection to db
	cur.close()