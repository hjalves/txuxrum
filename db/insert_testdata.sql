
-- conta especial do guest

--INSERT INTO users (UserID, Username, Password, UsernamePublic, ProfilePublic) VALUES (0, '<guest>', '', TRUE, FALSE);

-- utilizadores

INSERT INTO users (Username, Password, Name, Male, Mail, Location, Birthday) VALUES ('ze', md5('ze'), 'Ze', TRUE, 'ze@dei.uc.pt', 'Coimbra', '1989-12-21');
INSERT INTO users (Username, Password, Name, Male, Mail, Location, Birthday) VALUES ('maria', md5('maria'), 'Maria', FALSE, 'maria@dei.uc.pt', 'Pampilhosa', '1991-03-04');

-- chatrooms

INSERT INTO chatrooms (OwnerID, Title) VALUES (1, 'Wololo');
INSERT INTO chatrooms (OwnerID, Title) VALUES (1, 'Coisas interessantes');
INSERT INTO chatrooms (OwnerID, Title) VALUES (2, 'Topico da maria');

-- mensagens

INSERT INTO messages (RoomID, UserID, MsgText) VALUES (1, 1, 'Aoe?');
INSERT INTO messages (RoomID, UserID, MsgText) VALUES (1, 2, 'Tenho cenas por fazer, ze.');

INSERT INTO messages (RoomID, UserID, MsgText) VALUES (2, 2, 'Ha coisas interessantes neste mundo');
INSERT INTO messages (RoomID, UserID, MsgText) VALUES (2, 1, 'Ele ha la agora');

INSERT INTO messages (RoomID, UserID, MsgText) VALUES (3, 2, 'Este topico e meu. Ah pois e');
INSERT INTO messages (RoomID, UserID, MsgText) VALUES (3, 2, 'E esta mensagem tambem');
INSERT INTO messages (RoomID, UserID, MsgText) VALUES (3, 2, 'Bitches dont know about my topics');
INSERT INTO messages (RoomID, UserID, MsgText) VALUES (3, 1, 'Ta ta');
