SELECT * FROM TOWN;


SELECT * FROM TOWN
WHERE Tname = 'Atlantic City';


SELECT Tcode, Tname, Sustain_rating FROM TOWN
WHERE County = 'Bergen';


SELECT Tname, County, Sustain_rating FROM TOWN
WHERE Tcode = '08601';


SELECT * FROM TOWN
WHERE Sustain_rating = 'High';


SELECT * FROM RESTAURANT;


SELECT Rname, Tcode, Address FROM RESTAURANT
WHERE Rest_sustain_rating = 'Average';


SELECT Rname, Tcode, Address FROM RESTAURANT
WHERE Rname = 'Greens and Grains';


SELECT Rname, Tcode, Rest_sustain_rating, Address FROM RESTAURANT
WHERE Tcode = '08723';


SELECT * FROM RESTAURANT
WHERE Vegan_friendly = 't';


SELECT * FROM RESTAURANT 
WHERE Address = '4 Hamburg Ave (at Loomis), Sussex, New Jersey';


SELECT * FROM VEGAN_OPTIONS;


SELECT * FROM VEGAN_OPTIONS
WHERE Rname = 'Leatherhead Pub';


SELECT Rname FROM VEGAN_OPTIONS
WHERE Options = 'hummus plate, cauliflower pizza, fried artichoke plus salads, veggie sandwiches';


SELECT * FROM SUSTAINABILITY;


SELECT * FROM SUSTAINABILITY
WHERE Tcode = '08043';


SELECT * FROM SUSTAINABILITY 
WHERE CO2_Emissions <= 38;


SELECT Tcode, Energy_per_acre FROM SUSTAINABILITY
WHERE Energy_per_acre >= 15;


SELECT Tcode, Sustain_rating FROM SUSTAINABILITY
WHERE Sustain_rating = 'Average';


SELECT Tcode, Perc_renew_energy FROM SUSTAINABILITY
WHERE Perc_renew_energy >= 25;


SELECT Tname, County, SUSTAINABILITY.*
FROM TOWN JOIN SUSTAINABILITY on TOWN.Tcode = SUSTAINABILITY.Tcode
WHERE TOWN.Sustain_rating = 'Average';


SELECT RESTAURANT.Rname, Tcode, Vegan_Friendly, Vegan_options
FROM RESTAURANT JOIN VEGAN_OPTIONS ON RESTAURANT.Rname = VEGAN_OPTIONS.Rname
WHERE Vegan_Friendly = 't';


SELECT Tname, Sustain_Rating, Rname, Address
FROM TOWN JOIN RESTAURANT ON RESTAURANT.Tcode = TOWN.Tcode
WHERE Sustain_rating = 'Low';

SELECT COUNT(TOWN.Tcode) AS COUNT_TOWNS_OVER_15_EPA
FROM TOWN JOIN SUSTAINABILITY ON TOWN.Tcode = SUSTAINABILITY.Tcode
WHERE Energy_per_acre > 15;

SELECT Tname, Rname, SUSTAINABILITY.Sustain_rating, CO2_Emissions
FROM 
(SELECT TOWN.Tname, RESTAURANT.*
FROM TOWN JOIN RESTAURANT on RESTAURANT.Tcode = TOWN.Tcode
WHERE Sustain_rating = 'Low') AS TOWN_RESTAURANT_LOW
JOIN SUSTAINABILITY ON SUSTAINABILITY.Tcode = TOWN_RESTAURANT_LOW.Tcode
WHERE CO2_Emissions < 35;

SELECT Tname, Rname, Vegan_Options
FROM 
(SELECT Vegan_Options, RESTAURANT.Rname, Tcode
FROM VEGAN_OPTIONS JOIN RESTAURANT on RESTAURANT.Rname = VEGAN_OPTIONS.Rname) 
AS RESTAURANT_VEGAN_OPTIONS
JOIN TOWN ON TOWN.Tcode = RESTAURANT_VEGAN_OPTIONS.Tcode
WHERE County = 'Bergen';
