DROP DATABASE if EXISTS alumni_club;
CREATE DATABASE alumni_club;
USE alumni_club;
CREATE TABLE users (
  id int NOT NULL primary key AUTO_INCREMENT comment 'primary key',
  username varchar(20) NOT NULL UNIQUE,
  password varchar(25) NOT NULL,
  firstName varchar(20) NOT NULL,
  lastName varchar(20) NOT NULL,
  email varchar(30) NOT NULL UNIQUE,
  role ENUM('admin', 'user') NOT NULL
) default charset utf8 comment '';
CREATE TABLE additionalInfo (
  id int NOT NULL primary key AUTO_INCREMENT comment 'primary key',
  userId int NOT NULL,
  speciality varchar(50) NOT NULL,
  graduationYear year(4) DEFAULT 1970,
  group_uni int(10) NOT NULL,
  faculty varchar(50) NOT NULL,
  locationId int NOT NULL -- privacySettingsId int NOT NULL foreign key REFERENCES privacySettings(id), TODO
) default charset utf8 comment '';
CREATE TABLE contacts (
  id int NOT NULL primary key AUTO_INCREMENT,
  firstUserId int NOT NULL,
  secondUserId int NOT NULL,
  create_time DATETIME COMMENT 'create time'
) default charset utf8 comment '';
CREATE TABLE locations (
  id int NOT NULL primary key AUTO_INCREMENT comment 'primary key',
  longitude varchar(30),
  latitude varchar(30),
  address varchar(30) NOT NULL
) default charset utf8 comment '';
-- CREATE TABLE privacySettings (
--   id int NOT NULL primary key AUTO_INCREMENT comment 'primary key',
--   scope ENUM(
--     'all',
--     'group',
--     'specialty',
--     'faculty',
--     'private'
--   )
-- ) default charset utf8 comment '';
-- maybe to rename it (posts->invitations)
CREATE TABLE posts (
  id int NOT NULL primary key AUTO_INCREMENT comment 'primary key',
  -- if the post is visible by certain group
  privacy ENUM(
    'all',
    'group',
    'specialty',
    'faculty',
    'private' -- MAYBE CHANGE IT TO CONTACTS
  ) NOT NULL,
  userId int NOT NULL,
  occasion VARCHAR(255) NOT NULL,
  locationId int NOT NULL,
  content VARCHAR(255) NOT NULL,
  event_date DATETIME COMMENT 'event time' NOT NULL,
  create_time DATETIME COMMENT 'create time' NOT NULL,
  likes int -- coming to the event
) default charset utf8 comment '';
CREATE TABLE comments (
  id int NOT NULL primary key AUTO_INCREMENT comment 'primary key',
  userId int NOT NULL,
  postId int NOT NULL,
  content VARCHAR(255) NOT NULL,
  create_time DATETIME COMMENT 'create time'
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