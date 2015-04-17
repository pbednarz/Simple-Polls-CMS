INSERT INTO `polls`.`user` (`userId`, `birthDate`, `sex`, `createDate`) VALUES (NULL, '1991-09-11 00:00:00', 'male', CURRENT_TIMESTAMP), (NULL, '2000-04-06 00:00:00', 'female', CURRENT_TIMESTAMP), (NULL, '1992-02-01 00:00:00', 'female', CURRENT_TIMESTAMP), (NULL, '1989-11-11 00:00:00', 'male', CURRENT_TIMESTAMP), (NULL, '1992-10-11 00:00:00', 'male', CURRENT_TIMESTAMP);

INSERT INTO `polls`.`poll` (`pollId`, `title`, `createDate`) VALUES (NULL, 'Pierwsza ankieta', CURRENT_TIMESTAMP), (NULL, 'Druga ankieta', CURRENT_TIMESTAMP);

INSERT INTO `polls`.`question` (`questionId`, `pollId`, `text`, `allowMultipleAnswers`) VALUES (NULL, '1', 'Jaki jest twój ulubiony kolor?', '0'), (NULL, '1', 'Wybierz interesujące cię sporty', '1'), (NULL, '2', 'Z jakiej przeglądarki korzystasz w pracy:', '1');

INSERT INTO `polls`.`answer` (`answerId`, `questionId`, `pollId`, `text`) VALUES (NULL, '1', '1', 'Czarny'), (NULL, '1', '1', 'Czerwony'), (NULL, '1', '1', 'Niebieski'), (NULL, '1', '1', 'Zielony'), (NULL, '1', '1', 'Inny');
INSERT INTO `polls`.`answer` (`answerId`, `questionId`, `pollId`, `text`) VALUES (NULL, '2', '1', 'Formuła F1'), (NULL, '2', '1', 'Tenis'), (NULL, '2', '1', 'Piłka nożna'), (NULL, '2', '1', 'Inny');
INSERT INTO `polls`.`answer` (`answerId`, `questionId`, `pollId`, `text`) VALUES (NULL, '3', '2', 'Chrome'), (NULL, '3', '2', 'Safari'), (NULL, '3', '2', 'Firefox'), (NULL, '3', '2', 'Internet Explorer');
INSERT INTO `polls`.`admin` (`adminId`, `username`, `password`, `email`, `createTime`) VALUES (NULL, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@gooogle.com', CURRENT_TIMESTAMP);