-- Create database tables
-- basimoes, hjalves, tlevita (LEI-BD 2012/2013)

-- (Para criar db usar comando: 'createdb txux')
-- (Depois, 'psql -f create_tables.sql txux')

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
    NameIsPublic    boolean,
    ProfileIsPublic boolean,
    IsDeleted       boolean,
    Mail            varchar,
    Location        varchar,
    Birthday        date
);

CREATE TABLE chatrooms (
    RoomID          serial      PRIMARY KEY,
    Theme           varchar
);

CREATE TABLE permissions (
    UserID          integer     REFERENCES users,
    RoomID          integer     REFERENCES chatrooms,
    Owns            boolean,
    CanPost         boolean,
    Banned          boolean,
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
    PostTime        timestamp
);

CREATE TABLE privatemessages (
    PvtMsgID        serial      PRIMARY KEY,
    SenderID        integer     REFERENCES users (UserID),
    ReceiverID      integer     REFERENCES users (UserID),
    MsgText         varchar,
    SendTime        timestamp,
    ReadTime        timestamp
);

CREATE TABLE documents (
    DocID           serial      PRIMARY KEY,
    MsgID           integer     REFERENCES messages,
    PvtMsgID        integer     REFERENCES privatemessages,
    Filename        varchar
);

-- Create sequences

--CREATE SEQUENCE users_UserID_seq owned by users.UserID;
--CREATE SEQUENCE rooms_RoomID_seq owned by chatrooms.RoomID;
--CREATE SEQUENCE messages_MsgID_seq owned by messages.MsgID;
--CREATE SEQUENCE privatemessages_PvtMsgID_seq owned by privatemessages.PvtMsgID;
--CREATE SEQUENCE documents_DocID_seq owned by documents.DocID;
