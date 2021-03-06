DROP TABLE IF EXISTS entry,users,comment;

CREATE TABLE entry (
  news_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  owner VARCHAR(255) NOT NULL,
  displayedName VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  content TEXT NULL,
  creationDate VARCHAR(10) NOT NULL,
  class_id INTEGER NOT NULL,
  degreeClass_title VARCHAR (255) NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE users (
  id INTEGER  NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(32) NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE comment (
  comment_id INTEGER NOT NULL  PRIMARY KEY AUTO_INCREMENT,
  news_id INTEGER NOT NULL,
  owner VARCHAR(255) NOT NULL,
  displayedName VARCHAR(255),
  content TEXT NULL,
  creationDate VARCHAR(10) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;