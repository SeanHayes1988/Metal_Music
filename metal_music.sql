-- in order in terms of foreign keys 
DROP TABLE IF EXISTS genreArtists, genres, placeOfOrigin, artists;

CREATE TABLE placeOfOrigin (
  placeOfOriginID INT NOT NULL AUTO_INCREMENT,
  placeOfOrigin CHAR(255),
  PRIMARY KEY (placeOfOriginID)
);

CREATE TABLE artists (
  artistID INT NOT NULL AUTO_INCREMENT,
  artistName CHAR(255) NOT NULL,
  PRIMARY KEY (artistID)
);

CREATE TABLE genres (
  genreId INT NOT NULL AUTO_INCREMENT,
  genreName VARCHAR(50) NOT NULL,
  monthOfYear VARCHAR(13) NOT NULL,
  yearOfOrigin INT(4) NOT NULL,
  placeOfOriginID INT,       
  comments VARCHAR(1000),
  PRIMARY KEY (genreId),
  FOREIGN KEY (placeOfOriginID) REFERENCES placeOfOrigin(placeOfOriginID)
);

-- many to many relationship 
CREATE TABLE genreArtists (
  genreId INT,
  artistID INT,
  FOREIGN KEY (genreId) REFERENCES genres(genreId),
  FOREIGN KEY (artistID) REFERENCES artists(artistID),
  PRIMARY KEY (genreId, artistID)
);

-- part 2 

-- Insert a place of origin
INSERT INTO placeOfOrigin (placeOfOrigin) VALUES ('Birmingham England United Kingdom');

-- Insert an artist
INSERT INTO artists (artistName) VALUES ('Iron Maiden');

-- Insert a genre that references the placeOfOriginID (assume ID 1)
INSERT INTO genres (genreName, monthOfYear, yearOfOrigin, placeOfOriginID, comments)
VALUES ('New Wave of British Heavy Metal', 'December', 1975, 1, 'Classic British heavy metal band');

-- Link the genre (ID 1) with the artist (ID 1)
INSERT INTO genreArtists (genreId, artistID) VALUES (1, 1);
