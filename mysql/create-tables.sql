DROP DATABASE if EXISTS alumniClub;

CREATE DATABASE alumniClub;

USE alumniClub;

CREATE TABLE users (
  id              INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'primary key',
  username        VARCHAR(20) NOT NULL UNIQUE,
  password        VARCHAR(25) NOT NULL,
  firstName       VARCHAR(20), -- NOT NULL,
  lastName        VARCHAR(20), -- NOT NULL,
  email           VARCHAR(30) NOT NULL UNIQUE,
  role            ENUM('admin', 'user') -- NOT NULL
) default charset utf8 comment '';

CREATE TABLE additionalInfo (
  id              INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'primary key',
  userId          INT NOT NULL,
  speciality      VARCHAR(50) NOT NULL,
  graduationYear  YEAR(4) DEFAULT 1970,
  groupUni        INT(10) NOT NULL,
  faculty         VARCHAR(50) NOT NULL,
  locationId      INT NOT NULL
) default charset utf8 comment '';

CREATE TABLE contacts (
  id              INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  firstUserId     INT NOT NULL,
  secondUserId    INT NOT NULL,
  createTime      DATETIME COMMENT 'create time'
) default charset utf8 comment '';

CREATE TABLE locations (
  id              INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'primary key',
  longitude       VARCHAR(30),
  latitude        VARCHAR(30),
  address         VARCHAR(30) NOT NULL
) default charset utf8 comment '';

-- posts = invitations
CREATE TABLE posts (
  id              INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'primary key',
  -- visibility
  privacy         ENUM(
                      'all',
                      'group',
                      'specialty',
                      'faculty',
                      'private' -- a.k.a people in your contacts
                  ) NOT NULL,
  userId          INT, -- NOT NULL,
  occasion        VARCHAR(255) NOT NULL,
  -- locationId      INT NOT NULL,
  location        VARCHAR(255) NOT NULL,
  content         VARCHAR(255) NOT NULL,
  occasionDate    DATETIME COMMENT 'event time' NOT NULL,
  createTime      DATETIME COMMENT 'create time', -- NOT NULL,
  likes           INT -- coming to the event
) default charset utf8 comment '';

CREATE TABLE comments (
  id              INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'primary key',
  userId          INT NOT NULL,
  postId          INT NOT NULL,
  content         VARCHAR(255) NOT NULL,
  createTime      DATETIME COMMENT 'create time'
) default charset utf8 comment '';

CREATE TABLE tokens (
  id              INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'primary key',
  token           VARCHAR(255),
  userId          INT NOT NULL,
  expires         DATETIME
) default charset utf8 comment '';

ALTER TABLE
  additionalInfo
ADD
  CONSTRAINT FK_User_Info FOREIGN KEY (userId) REFERENCES users(id);

ALTER TABLE
  additionalInfo
ADD
  CONSTRAINT FK_Location_Info FOREIGN KEY (locationId) REFERENCES locations(id);

ALTER TABLE
  contacts
ADD
  CONSTRAINT FK_Contact_User_1 FOREIGN KEY (firstUserId) REFERENCES users(id);

ALTER TABLE
  contacts
ADD
  CONSTRAINT FK_Contact_User_2 FOREIGN KEY (secondUserId) REFERENCES users(id);

ALTER TABLE
  posts
ADD
  CONSTRAINT FK_Posts_Settings FOREIGN KEY (privacySettingsId) REFERENCES privacySettings(id);

ALTER TABLE
  posts
ADD
  CONSTRAINT FK_Posts_Users FOREIGN KEY (userId) REFERENCES users(id);

ALTER TABLE
  posts
ADD
  CONSTRAINT FK_Posts_Location FOREIGN KEY (locationId) REFERENCES locations(id);

ALTER TABLE
  comments
ADD
  CONSTRAINT FK_Comments_Post FOREIGN KEY (postId) REFERENCES posts(id);

ALTER TABLE
  comments
ADD
  CONSTRAINT FK_Comments_Users FOREIGN KEY (userId) REFERENCES users(id);

ALTER TABLE
  tokens
ADD
  CONSTRAINT FK_Tokens_Users FOREIGN KEY (userId) REFERENCES users(id);