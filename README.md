**Introduction**

As the consequences and long-term effects of global CO2 emissions have become prominent, many companies and countries are trying to do their part by working toward climate control and carbon neutrality. Another big factor in helping climate change is making the change from meat-based food options to plant-based and vegan food options. Not only does this diet have a benefit for your personal health but the impact on the environment is just as great. Our module will allow for people who live in New Jersey, or are thinking about moving here, to see how we are doing in terms of sustainability and if there is a certain town or county that is leading the pack.

The issue we want to address is part of the larger issue of climate change and sustainability. Eating foods involving animal products and other harmful elements has more of an impact on the environment than say vegan options. We want to solve the issue of some people not being aware of these options or being able to find that.


**Instructions on Running the Project:**
- The database to be created should be named njsus.
- create_tables.txt has the sql to create all the tables.
	- drop_tables.txt is included to easily drop the tables.
- Data is stored in files restaurants.txt, town.txt, vegan_options.txt, and sustainability.txt.
- config.py, database.ini, and config.pyc are all files used with psycopg2, no need to be editted.
	- Ensure you have psycopg2 properly installed (look to 7dbs.zip on canvas)
- Run njsus.py once the tables have been created and data will be pulled from the data files, formatted, and stored into the corresponding tables.
- Example queries that can be ran on the database are stored in the queries.txt file.
- queries_demonstrate.sql is a sql script that can be run to test and view results of all queries from queries.txt
- Stage V-B.pdf has all the past pdfs and current Stage V pdf with some data repeated.

PHP:
- In order to get test.php into your apache web server folder, copy test.php into the directory var/www/html by going into terminal, navigating to location of test.php and running 'sudo cp test.php /var/www/html'
- Now go to the web browser and navigate to localhost/test.php
