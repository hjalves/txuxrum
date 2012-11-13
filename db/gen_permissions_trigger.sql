/*  Procedure called when a room is inserted in chatrooms table
*   in order to create default permissions for all users.
*/
CREATE OR REPLACE FUNCTION generate_permissions_insroom()
RETURNS trigger
AS $$

DECLARE

    users_cur CURSOR FOR SELECT * FROM users WHERE userid != NEW.ownerid;
    user_rec RECORD;

BEGIN

    INSERT INTO permissions (userid, roomid, canpost, banned) values (NEW.ownerid, NEW.roomid, 'TRUE', 'FALSE');

    FOR user_rec IN users_cur LOOP
        INSERT INTO permissions (userid, roomid, canpost, banned) values (user_rec.userid, NEW.roomid, 'FALSE', 'FALSE');
    END LOOP;
        
    RETURN NEW;
    
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER gen_permissions_trigger_insroom
AFTER INSERT ON chatrooms
FOR EACH ROW EXECUTE PROCEDURE generate_permissions_insroom();



/*  Procedure called when a user is inserted in the users table
*   In order to create his permissions for all the rooms
*/
CREATE OR REPLACE FUNCTION generate_permissions_insuser()
RETURNS trigger
AS $$

DECLARE

    rooms_cur CURSOR FOR SELECT roomid FROM chatrooms;
    room_rec RECORD;

BEGIN

    FOR room_rec IN rooms_cur LOOP 
        INSERT INTO permissions (userid, roomid, canpost, banned) values (NEW.userid, room_rec.roomid, 'FALSE', 'FALSE');        
    END LOOP;
    
    RETURN NEW;
    
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER gen_permissions_trigger_insroom
AFTER INSERT ON users
FOR EACH ROW EXECUTE PROCEDURE generate_permissions_insuser();

