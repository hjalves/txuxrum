-- TODO: colocar isto no max_val
-- select COUNT(DISTINCT userid) from messages
-- where roomid = NEW.roomid

DROP TRIGGER rate_trigger ON ratings;

CREATE OR REPLACE FUNCTION rate_limit_check()
RETURNS trigger
AS $$

DECLARE

    max_val INTEGER;
    n_rates INTEGER;

BEGIN

    LOCK TABLE ratings IN EXCLUSIVE MODE;

    select COUNT(DISTINCT userid) from messages into max_val where roomid = NEW.roomid;

    select COUNT(DISTINCT userid) from ratings into n_rates where roomid = NEW.roomid;

    IF n_rates >= max_val
        THEN
            RAISE EXCEPTION 'rating limit for this room reached';
    END IF;
    
    RETURN NEW;
    
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER rate_trigger
BEFORE INSERT ON ratings
FOR EACH ROW
EXECUTE PROCEDURE rate_limit_check();



