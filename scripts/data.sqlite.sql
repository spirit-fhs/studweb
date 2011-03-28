INSERT INTO entry (user,displayName, subject, news, crdate) VALUES
('KUENZEL','Künzel', 'ITIL-Blockseminar', 'Das ITIL-Blockseminar bei Herrn Winkelmann findet am 25.02.11 ab 8:15 Uhr im PC-Pool1 (B0107) statt.', DATETIME('NOW'));
INSERT INTO entry (user,displayName, subject, news, crdate) VALUES
('KUENZEL','Künzel', 'ITIL', 'Herrn Winkelmann findet am 25.02.11 ab 8:15 Uhr im PC-Pool1 (B0107) statt.', DATETIME('NOW'));
INSERT INTO entry (user,displayName, subject, news, crdate) VALUES
('KUENZEL','Künzel', 'ITIL', 'Herrn Winkelmann findet am 25.02.11 ab 8:15 Uhr im PC-Pool1 (B0107) statt.', DATETIME('NOW'));
INSERT INTO users ('username', 'password') VALUES ('Student', 'geheim');
INSERT INTO comment (user, entryId, comment, crdate) VALUES ('KUENZEL2', 1, 'blubl dasdwads.', strftime('%d.%m.%Y', 'NOW'));
INSERT INTO comment (user, entryId, comment, crdate) VALUES ('KUENZEL2', 1, 'blubl dasdwads.', strftime('%d.%m.%Y', 'NOW'));
