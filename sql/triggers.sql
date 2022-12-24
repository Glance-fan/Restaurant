CREATE OR REPLACE FUNCTION clear_order() RETURNS TRIGGER AS $clear_order_trigger$
	DECLARE 
      	found_id BIGINT;
	BEGIN
    	SELECT order_id INTO found_id FROM receipt ORDER BY date_closed desc, time_close desc LIMIT 1;
      	UPDATE restaurant_table SET order_id = NULL, waiter_id = NULL WHERE order_id = found_id;
      	DELETE FROM ordered_dish WHERE order_id = found_id;
      	UPDATE customer_order SET status = true WHERE id = found_id; 
      	RETURN NEW;
	END;
$clear_order_trigger$ LANGUAGE plpgsql;
CREATE OR REPLACE TRIGGER clear_order_trigger 
	AFTER INSERT ON receipt
    FOR EACH ROW 
    EXECUTE FUNCTION clear_order();

CREATE OR REPLACE FUNCTION ordered_time() RETURNS TRIGGER AS $ordered_time_trigger$
	  BEGIN
    	  EXECUTE format('update dish set ordered_time = ordered_time + 1 where id = %L', NEW.dish_id);
    	  RETURN NEW;
    END;
$ordered_time_trigger$ LANGUAGE plpgsql;
CREATE OR REPLACE TRIGGER ordered_time_trigger
  	AFTER INSERT ON ordered_dish
  	FOR EACH ROW
  	EXECUTE FUNCTION ordered_time();

CREATE OR REPLACE FUNCTION ordered_time() RETURNS TRIGGER AS $ordered_time_trigger$
	  BEGIN
    	  EXECUTE format('update dish set ordered_time = ordered_time + 1 where id = %L', NEW.dish_id);
    	  RETURN NEW;
	END;
$ordered_time_trigger$ LANGUAGE plpgsql;
CREATE OR REPLACE TRIGGER ordered_time_trigger
  	AFTER INSERT ON ordered_dish
  	FOR EACH ROW
  	EXECUTE FUNCTION ordered_time();