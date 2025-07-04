DROP TABLE IF EXISTS genres, placeOfOrigin;

CREATE TABLE genres (
  genre_name varchar(50) NOT NULL,
  monthV varchar(13) NULL,
  yearV int(4) NOT NULL,
  place_of_origin text NOT NULL,
  notable_bands text NOT NULL,
  comments varchar(1000) NULL,
  PRIMARY KEY (genre_name)
  );

CREATE TABLE placeOfOrigin (
  p_of_oID int NOT NULL AUTO_INCREMENT,
  place_of_origin char(255) NULL,
  PRIMARY KEY (p_of_oID)
  );

CREATE TABLE notableBands (
  notableBandsID int NOT NULL AUTO_INCREMENT,
  notable_bands char(255) NULL,
  PRIMARY KEY (notableBandsID)
  );

/*  places_of_origin char(255) NULL,
  notable_bands varchar(1000) NULL,
  comments varchar(1000) NULL,*/

/* ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;*/
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table 'genres'
--

LOCK TABLES genres WRITE;
/*!40000 ALTER TABLE 'genres' DISABLE KEYS */;
INSERT INTO genres VALUES ('Heavy Metal ','13 February 1970','Birmingham England UK','Black Sabbath, Motörhead, Judas Priest','Some consider Led Zeppelin and Deep Purple the orginal Heavy Metal Bands');
/*!40000 ALTER TABLE 'genres' ENABLE KEYS */;
UNLOCK TABLES;

--