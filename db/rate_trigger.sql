DROP TRIGGER rate_trigger ON ratings;

CREATE OR REPLACE FUNCTION rate_limit_check()
RETURNS trigger
AS $$

DECLARE

    max_val CONSTANT INTEGER NOT NULL := 5;
    n_rates INTEGER;

BEGIN

    LOCK TABLE ratings IN EXCLUSIVE MODE;

    PERFORM * FROM ratings WHERE roomid = NEW.roomid;

    GET DIAGNOSTICS n_rates = ROW_COUNT;

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



