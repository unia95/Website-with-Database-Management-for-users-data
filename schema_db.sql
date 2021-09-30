CREATE DATABASE MyCard;
USE MyCard;
CREATE TABLE ACCOUNT (
  user_id     INT NOT NULL AUTO_INCREMENT UNIQUE,
  activation_date    DATE NOT NULL,  
  passw       VARCHAR(50) NOT NULL,  
  username       VARCHAR(20) NOT NULL,  
  PRIMARY KEY (user_id),
  UNIQUE (username))
ENGINE = 'InnoDB';

CREATE TABLE USERS (
  user_id     INT NOT NULL UNIQUE,
  name        VARCHAR(20) NOT NULL,
  surname     VARCHAR(20) NOT NULL,
  birth       DATE NOT NULL,
  email       VARCHAR(40) NOT NULL,  
  photo       BLOB NULL,
  INDEX newUser(user_id),
  PRIMARY KEY (user_id),
  FOREIGN KEY (user_id) REFERENCES ACCOUNT (user_id))
ENGINE = 'InnoDB';


CREATE TABLE  MEETING (
  meeting_id  INT NOT NULL AUTO_INCREMENT UNIQUE,
  user_id     INT NOT NULL,
  title       VARCHAR(40) NOT NULL,
  place       VARCHAR(40) NOT NULL,
  date        DATETIME,
  topic       VARCHAR(300) NULL,
  inv		  INT NULL,
  card_id	  INT NULL,
  lang		  VARCHAR(20) NOT NULL,
  INDEX newMEETING (user_id),
  PRIMARY KEY (meeting_id),
  FOREIGN KEY (user_id) REFERENCES USERS (user_id))
ENGINE = 'InnoDB';

CREATE TABLE  EDUCATION_EXPERIENCE (
education_experience_id   INT NOT NULL AUTO_INCREMENT UNIQUE,
title VARCHAR (20) NOT NULL,
year 		   INT NOT NULL,
place VARCHAR (20) NOT NULL,
user_id     INT NOT NULL,
INDEX user_idx (user_id),
PRIMARY KEY (education_experience_id),
FOREIGN KEY (user_id) REFERENCES USERS (user_id))
ENGINE = 'InnoDB';

CREATE TABLE  COMPANY (
 company_id   INT NOT NULL AUTO_INCREMENT UNIQUE,
 name         VARCHAR (20) NOT NULL,
 place        VARCHAR (40) NOT NULL,
 web          VARCHAR (40) NOT NULL,
 email        VARCHAR (40) NOT NULL,
 note         VARCHAR (300) NULL,
 PRIMARY KEY (company_id))
ENGINE = 'InnoDB';

CREATE TABLE  WORK_EXPERIENCE (
work_experience_id   INT NOT NULL AUTO_INCREMENT UNIQUE,
company_id  INT NOT NULL,
user_id     INT NOT NULL,
role VARCHAR (20) NOT NULL,
year 		   INT NOT NULL,
place VARCHAR (20) NOT NULL,
INDEX user_idx (user_id),
INDEX company_idx (company_id),
PRIMARY KEY (work_experience_id),
FOREIGN KEY (user_id) REFERENCES USERS (user_id),
FOREIGN KEY (company_id) REFERENCES COMPANY (company_id))
ENGINE = 'InnoDB';



CREATE TABLE  INVITE (
  user_id     INT NOT NULL,
  meeting_id  INT NOT NULL,
  reply	  	  INT NOT NULL,
  INDEX newID (user_id),
  INDEX newINVITE (meeting_id),
  PRIMARY KEY (user_id, meeting_id),
  FOREIGN KEY (user_id) REFERENCES USERS (user_id),
  FOREIGN KEY (meeting_id) REFERENCES MEETING (meeting_id))
ENGINE = 'InnoDB';





CREATE TABLE  CARDS (
  card_id     INT NOT NULL AUTO_INCREMENT UNIQUE,
  user_id     INT NOT NULL,
  title       VARCHAR(20) NOT NULL,
  name        VARCHAR(20) NOT NULL,
  surname     VARCHAR(20) NOT NULL,
  email       VARCHAR(40) NOT NULL,
  phone       VARCHAR(20) NOT NULL,
  photo       BLOB NULL,
  note        VARCHAR(300),
  education_experience_id  INT NOT NULL,
  work_experience_id  INT NOT NULL,
  INDEX education_experience_idx (education_experience_id),
  INDEX work_experience_idx (work_experience_id),
  INDEX newCARD (user_id),
  PRIMARY KEY (card_id),
  FOREIGN KEY (user_id) REFERENCES USERS (user_id),
  FOREIGN KEY (education_experience_id) REFERENCES EDUCATION_EXPERIENCE (education_experience_id),
  FOREIGN KEY (work_experience_id) REFERENCES WORK_EXPERIENCE (work_experience_id))
ENGINE = 'InnoDB';


CREATE TABLE  PARTECIPATE (
  user_id     INT NOT NULL,
  meeting_id  INT NOT NULL,
  card_id	  INT NOT NULL,
  INDEX new_ID (user_id),
  INDEX newPARTECIPATE (meeting_id),
  INDEX card_idx (card_id),
  PRIMARY KEY (user_id, meeting_id),
  FOREIGN KEY (user_id) REFERENCES USERS (user_id),
  FOREIGN KEY (meeting_id) REFERENCES MEETING (meeting_id),
  FOREIGN KEY (card_id) REFERENCES CARDS (card_id))
ENGINE = 'InnoDB';


CREATE TABLE  mycard.WALLET (
  user_id     INT NOT NULL,
  meeting_id  INT NOT NULL,
  card_id     INT NOT NULL,
  note        VARCHAR (300) NULL,
  rating_usefull TINYINT NULL,
  rating_importance TINYINT NULL,
  INDEX new_USER (user_id),
  INDEX new_MEETING (meeting_id),
  INDEX newWALLET (card_id),
  PRIMARY KEY (user_id, meeting_id, card_id))
ENGINE = 'InnoDB';

CREATE TABLE mycard.MESSAGES(
	message_id INT NOT NULL AUTO_INCREMENT UNIQUE,
    user_id_invito INT NOT NULL,
    meeting_id INT NOT NULL)
ENGINE = 'InnoDB';

CREATE TABLE  mycard.USER_RATING (
  user_id     INT NOT NULL,
  meeting_id  INT NOT NULL,
  rated_user  INT NOT NULL,
  note        VARCHAR (300) NULL,
  professionality TINYINT NULL,
  availability    TINYINT NULL,
  impression    TINYINT NULL,
  INDEX new_USER (user_id),
  INDEX new_RatedUser (rated_user),
  INDEX new_Meeting (meeting_id),
  PRIMARY KEY (user_id, meeting_id, rated_user))
ENGINE = 'InnoDB';