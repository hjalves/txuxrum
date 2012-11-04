-- Create database tables
-- basimoes, hjalves, tlevita (LEI-BD 2012/2013)

-- (Fazer primeiro: 'createuser -U postgres -P txux')
-- (Introduzir a password desejada para txux)
-- (Allow this role to create dbs? Yes!)
-- (Depois criar db: 'createdb -U txux')
-- (Finalmente, 'psql -U txux -f create_tables.sql')


-- First, drop tables and dependencies

DROP TABLE users CASCADE;
DROP TABLE chatrooms CASCADE;
DROP TABLE permissions CASCADE;
DROP TABLE messages CASCADE;
DROP TABLE privatemessages CASCADE;
DROP TABLE documents CASCADE;
DROP TABLE ratings CASCADE;

-- Then, create tables

CREATE TABLE users (
    UserID          serial      PRIMARY KEY,
    Username        varchar(16),
    Password        varchar,
    NameIsPublic    boolean     DEFAULT TRUE,
    ProfileIsPublic boolean     DEFAULT TRUE,
    IsDeleted       boolean     DEFAULT FALSE,
    Mail            varchar,
    Location        varchar,
    Birthday        date
);

CREATE TABLE chatrooms (
    RoomID          serial      PRIMARY KEY,
    OwnerID         integer     REFERENCES users (UserID),
    Theme           varchar,
    IsClosed        boolean     DEFAULT FALSE,
    CreationDate    date        DEFAULT current_date
);

CREATE TABLE permissions (
    UserID          integer     REFERENCES users,
    RoomID          integer     REFERENCES chatrooms,
    CanPost         boolean     DEFAULT FALSE,
    Banned          boolean     DEFAULT FALSE,
    PRIMARY KEY (UserID, RoomID)
);

CREATE TABLE ratings (
    UserID          integer     REFERENCES users,
    RoomID          integer     REFERENCES chatrooms,
    Value           integer,
    PRIMARY KEY (UserID, RoomID),
    CHECK(Value >= 0 AND Value <= 2)
);

CREATE TABLE messages (
    MsgID           serial      PRIMARY KEY,
    RoomID          integer     REFERENCES chatrooms,
    UserID          integer     REFERENCES users,
    MsgText         varchar,
    PostTime        timestamp   DEFAULT current_timestamp
);

CREATE TABLE privatemessages (
    PvtMsgID        serial      PRIMARY KEY,
    SenderID        integer     REFERENCES users (UserID),
    ReceiverID      integer     REFERENCES users (UserID),
    MsgText         varchar,
    SendTime        timestamp   DEFAULT current_timestamp,
    ReadTime        timestamp
);

CREATE TABLE documents (
    DocID           serial      PRIMARY KEY,
    MsgID           integer     REFERENCES messages,
    PvtMsgID        integer     REFERENCES privatemessages,
    Filename        varchar
);

-- Create sequences
-- CREATE SEQUENCE users_UserID_seq owned by users.UserID;
-- CREATE SEQUENCE rooms_RoomID_seq owned by chatrooms.RoomID;
-- CREATE SEQUENCE messages_MsgID_seq owned by messages.MsgID;
-- CREATE SEQUENCE privatemessages_PvtMsgID_seq owned by privatemessages.PvtMsgID;
-- CREATE SEQUENCE documents_DocID_seq owned by documents.DocID;

