DROP TRIGGER delete_message_trigger ON privatemessages;

CREATE OR REPLACE FUNCTION delete_message_check()
RETURNS trigger
AS $$

BEGIN

	LOCK TABLE privatemessages IN EXCLUSIVE MODE;
    
	IF (Old.readtime IS NOT NULL) THEN
		RAISE EXCEPTION 'message has already been shared, impossible to erase it';
	END IF;

    RETURN Old;
    
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER delete_message_trigger 
BEFORE DELETE ON privatemessages
FOR EACH ROW EXECUTE PROCEDURE delete_message_check();

