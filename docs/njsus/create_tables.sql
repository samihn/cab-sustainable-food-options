CREATE TABLE TOWN
	(Tcode varchar(5) NOT NULL UNIQUE PRIMARY KEY,
	Tname text NOT NULL,
	County text,
	Sustain_rating text NOT NULL);


CREATE TABLE RESTAURANT
	(Rname text NOT NULL UNIQUE PRIMARY KEY,
	Tcode varchar(5) NOT NULL,
	Vegan_friendly boolean,
	Rest_sustain_rating text NOT NULL,
   	Address text NOT NULL,
   	FOREIGN KEY (Tcode) REFERENCES TOWN (Tcode));


CREATE TABLE VEGAN_OPTIONS
	(Rname text NOT NULL PRIMARY KEY,
	Options text,
	FOREIGN KEY (Rname) REFERENCES RESTAURANT (Rname));


CREATE TABLE SUSTAINABILITY
	(Tcode varchar(5) NOT NULL PRIMARY KEY,
	CO2_Emissions decimal NOT NULL,
	Energy_per_acre integer NOT NULL,
	Sustain_rating text NOT NULL,
	Perc_renew_energy integer NOT NULL,
	FOREIGN KEY (Tcode) REFERENCES TOWN (Tcode));

