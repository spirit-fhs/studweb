INSERT INTO users (username, password) VALUES ('Student', 'geheim');
INSERT INTO comment (owner, entryId, content, creationDate, displayedName) VALUES ('KUENZEL2', 1, 'blubl dasdwads.', DATE_FORMAT(NOW(),'%d.%m.%Y'), 'Frau Künzel');
INSERT INTO comment (owner, entryId, content, creationDate, displayedName) VALUES ('KUENZEL2', 1, 'blubl dasdwads.', DATE_FORMAT(NOW(),'%d.%m.%Y'), 'Frau Künzel');

INSERT INTO entry (owner,title,classes,displayedName, creationDate,  content) VALUES
('neuhardt','Ausfall Lehrveranstaltungen','I2 I4 IS4 MM4','Neuhardt','09.04.2011','Wegen Krankheit fallen meine Lehrveranstaltungen und meine Sprechstunde bis einschließlich Freitag, den 8. April, aus.\r\n\r\nNachholtermine werden in den Lehrveranstaltungen besprochen.');
INSERT INTO entry (owner,title,classes,displayedName, creationDate,  content) VALUES
('braun3','Sprechzeit 06.04. 13:00 -> 14:00','semester','Prof. Dr. Braun','15.04.2011','Auf Grund einer Dienstreise verschiebt sich meine Sprechzeit nächsten Mittwoch um eine Stunde nach hinten und findet von 13:00 - 14:00 statt.');
INSERT INTO entry (owner,title,classes,displayedName, creationDate,  content) VALUES
('kuenzel','','','Künzel','10.04.2011','Ihr Druckkontigent für die Drucker in den PC-Pools ist zurückgesetzt.\r\nDen aktuellen Stand sehen Sie unter: \\\\212.201.64.19\\pub\\drucker');
INSERT INTO entry (owner,title,classes,displayedName, creationDate,  content) VALUES
('neuhardt','Konsultationstermine Software Engineering','I2','Neuhardt','09.07.2011','Für das Projekt im Fach Software Engineering gibt es folgende Konsultationstermine:\r\n\r\n04.04., 14.15 Uhr, Team 1\r\n04.04., 15.00 Uhr, Team 2\r\n04.04., 16.00 Uhr, Team 3\r\n04.04., 16.45 Uhr, Team 4\r\n11.04., 14.15 Uhr, Team 5\r\n11.04., 15.00 Uhr, Team 6\r\n11.04., 16.00 Uhr, Team 7\r\n11.04., 16.45 Uhr, Team 8\r\n\r\nAlle Teams bringen zum Konsultationstermin ihre Lösung zur Aufgabe 1 mit.');
INSERT INTO entry (owner,title,classes,displayedName, creationDate,  content) VALUES
('braun3','Meine Veranstaltungen am 5. und 6.4. entfallen','I4 I6 IS2 MAI2 MAI4','Prof. Dr. Braun','15.04.2011','Aufgrund einer Dienstreise entfällt nächste Woche:\r\n\r\n* 05.04. Programmierung 2 Übung, BaIS2\r\n* 06.04. SWEProgV3 Übung, BaI4, BaI6\r\n* 06.04. Fortgeschrittene Funktionale Programmierung MaI2, MaI4');
INSERT INTO entry (owner,title,classes,displayedName, creationDate,  content) VALUES
('braun3','Sprechzeit 06.04. 13:00 -> 14:00','semester','Prof. Dr. Braun','15.04.2011','Auf Grund einer Dienstreise verschiebt sich meine Sprechzeit nächsten Mittwoch um eine Stunde nach hinten und findet von 13:00 - 14:00 statt.');
