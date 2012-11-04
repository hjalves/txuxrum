INSERT INTO users (UserID, Username, Password, UsernamePublic, ProfilePublic) VALUES (0, '<guest>', '', TRUE, FALSE);

INSERT INTO users (Username, Password, Name, Male, Mail, Location, Birthday) VALUES ('ze', md5('ze'), 'Ze', TRUE, 'ze@dei.uc.pt', 'Coimbra', '1989-12-21');
INSERT INTO users (Username, Password, Name, Male, Mail, Location, Birthday) VALUES ('maria', md5('maria'), 'Maria', FALSE, 'maria@dei.uc.pt', 'Pampilhosa', '1991-03-04');

INSERT INTO chatrooms (OwnerID, Title) VALUES (1, 'Wololo');
INSERT INTO chatrooms (OwnerID, Title) VALUES (1, 'Coisas interessantes');
INSERT INTO chatrooms (OwnerID, Title) VALUES (2, 'Topico da maria');