Read Me For NJSUS Database Part V
Matthew Izzo, Joe Candiano, Babette Chao, and Sam Hajnasrollahi

- The database to be created should be named njsus.
- create_tables.txt has the sql to create all the tables.
	- drop_tables.txt is included to easily drop the tables.
- Data is stored in files restaurants.txt, town.txt, vegan_options.txt, and sustainability.txt.
- config.py, database.ini, and config.pyc are all files used with psycopg2, no need to be editted.
	- Ensure you have psycopg2 properly installed (look to 7dbs.zip on canvas)
- Run njsus.py once the tables have been created and data will be pulled from the data files, formatted, and stored into the corresponding tables.
- Example queries that can be ran on the database are stored in the queries.txt file.
- queries_demonstrate.sql is a sql script that can be run to test and view results of all queries from queries.txt
- Stage V-A.pdf has all the past pdfs and current Stage V pdf with some data repeated.
