#! /usr/bin/python2

import psycopg2
from config import config
 
def connect():
    """ Connect to the PostgreSQL database server """
    conn = None
    try:
        # read connection parameters
        params = config()
 
        # connect to the PostgreSQL server
        print('Connecting to the %s database...' % params['database'])
        conn = psycopg2.connect(**params)
        print('Connected.\n')
      
        # create a cursor
        cur = conn.cursor()
        
        # execute a statement
        # print('PostgreSQL version:')
        cur.execute('SELECT version()')
 
        # display the PostgreSQL database server version
        db_version = cur.fetchone()
        # print(db_version[0])
       
        # execute a query using fetchall()
        # print('\nPostgreSQL SELECT result (sorted by country_code):')
        cur.execute("SELECT * FROM TOWN;")
        rows = cur.fetchall()
        print('The number of countries: %d' % cur.rowcount)
        for row in rows:
            print('%s\t%s' % (row[0], row[1]))

       # close the communication with the PostgreSQL
        cur.close()
    except (Exception, psycopg2.DatabaseError) as error:
        print(error)
    finally:
        if conn is not None:
            conn.close()
            print('\nDatabase connection closed.')
 
if __name__ == '__main__':
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

	f = open("town.txt")

	for y in f:
		x = (y.split('; '))
		one = str(x[0].strip())
		two = str(x[1].strip())
		three = str(x[2].strip())
		four = str(x[3].strip())
		cur.execute("INSERT INTO TOWN VALUES('%s', '%s', '%s', '%s');" %(one, two, three, four))
	f.close()

	f = open("restaurants.txt")

	for y in f:
		x = (y.split('; '))
		one = str(x[0].strip())
		two = str(x[1].strip())
		three = str(x[2].strip())
		four = str(x[3].strip())
		five = str(x[4].strip())
		cur.execute("INSERT INTO RESTAURANT VALUES('%s', '%s', '%s', '%s', '%s');" %(one, two, three, four, five))
	f.close()

	f = open("vegan_options.txt")

	for y in f:
		x = (y.split('; '))
		one = str(x[0].strip())
		two = str(x[1].strip())
		cur.execute("INSERT INTO VEGAN_OPTIONS VALUES('%s', '%s');" %(one, two))
	f.close()

	f = open("sustainability.txt")

	for y in f:
		x = (y.split('; '))
		one = str(x[0].strip())
		two = str(x[1].strip())
		three = str(x[2].strip())
		four = str(x[3].strip())
		five = str(x[4].strip())
		cur.execute("INSERT INTO SUSTAINABILITY VALUES('%s', '%s', '%s', '%s', '%s');" %(one, two, three, four, five))
	f.close()

	cur.close()

