DROP TABLE IF EXISTS genres, placeOfOrigin, artists;

CREATE TABLE genres (
  genreId int NOT NULL AUTO_INCREMENT,
  genreName varchar(50) NOT NULL,
  monthOfYear varchar(13) NOT NULL,
  yearOfOrigin int(4) NOT NULL,
  placeOfOrigin text NOT NULL,
  artistName text NOT NULL,
  comments varchar(1000),
  PRIMARY KEY (genreId)
  );

CREATE TABLE placeOfOrigin (
  placeOfOriginID int NOT NULL AUTO_INCREMENT,
  placeOfOrigin char(255) NULL,
  PRIMARY KEY (placeOfOriginID)
  );

CREATE TABLE artists (
  artistID int NOT NULL AUTO_INCREMENT,
  artistName char(255) NOT NULL,
  PRIMARY KEY (artistID)
  );
