DROP TRIGGER chatroom_post_trigger ON messages;

CREATE OR REPLACE FUNCTION post_permission_check()
RETURNS trigger
AS $$

DECLARE
    perm_rec current_permissions%ROWTYPE;
    
BEGIN

    SELECT * INTO perm_rec FROM current_permissions WHERE userid = NEW.userid AND roomid = NEW.roomid;

    IF (FOUND AND (NOT perm_rec.canpost))
        THEN
            RAISE EXCEPTION 'Cannot post in this chatroom';
    END IF;
    
    RETURN NEW;
    
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER chatroom_post_trigger 
BEFORE INSERT OR UPDATE ON messages
FOR EACH ROW EXECUTE PROCEDURE post_permission_check();

