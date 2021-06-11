INSERT INTO `users` 
(`id`, `username`, `password`, `firstName`, `lastName`, `email`, `role`,
 `speciality`, `graduationYear`, `groupUni`, `faculty`, `longitude`, `latitude`) 
 VALUES (NULL, 'user', '1234', 'User', 'Userov', 'user@abv.bg', 'user', 'SI',
'1970', '4', 'FMI', '23.2804297', '42.6592600');

INSERT INTO `users` 
(`id`, `username`, `password`, `firstName`, `lastName`, `email`, `role`,
 `speciality`, `graduationYear`, `groupUni`, `faculty`, `longitude`, `latitude`) 
 VALUES (NULL, 'userkatapetya', '12345', 'Petya', 'EQka', 'petyaEQka@abv.bg', 
 'user', 'SI', '1970', '4', 'FMI', '23.3177088', '42.6835968');

 INSERT INTO `users` 
 (`id`, `username`, `password`, `firstName`, `lastName`, `email`, `role`, 
 `speciality`, `graduationYear`, `groupUni`, `faculty`, `longitude`, `latitude`) 
 VALUES (NULL, 'userkatamaya', 'mayaeyaka', 'Maya', 'Qgodova', 'maya-yagodova@abv.bg',
  'user', 'SI', '2022', '4', 'FHF', NULL, NULL);

  INSERT INTO `users` 
  (`id`, `username`, `password`, `firstName`, `lastName`, `email`, `role`, 
  `speciality`, `graduationYear`, `groupUni`, `faculty`, `longitude`, `latitude`)
   VALUES (NULL, 'selena', 'azsumthebest', 'Selena', 'Testova', 'selencheto@gmai.com', 
   'user', 'Farmaciya', '1999', '1', 'BF', NULL, NULL);

INSERT INTO `posts` 
(`id`, `privacy`, `userId`, `occasion`, `location`, `content`, `occasionDate`,
 `likes`) VALUES (NULL, 'group', '1', 'Birthday party', 'Zlatograd', 
 'Heeey, guys. Come to my birthday party and lets have fun! :)))', '2021-06-22 00:10:23', NULL);

 INSERT INTO `posts` 
 (`id`, `privacy`, `userId`, `occasion`, `location`, `content`, `occasionDate`,
  `likes`) VALUES (NULL, 'faculty', NULL, 'Izlizanka', 'Studentski park', 
  'Just a casual gathering to play some games and talk about everything. 
  If you are looking for some fun, you are welcome to come <3', '2021-06-24 19:00:00', NULL);