/*добавление нового заказа -- функция официанта/менеджера*/
CREATE OR REPLACE FUNCTION new_order (waiter INTEGER) RETURNS INTEGER AS $$
	DECLARE
		return_id INTEGER;
	BEGIN
		EXECUTE format('INSERT INTO customer_order (waiter_id, date_created, time_open, status) VALUES (%L, %L, %L, %L)', waiter, CURRENT_DATE, CURRENT_TIME(0), false);
		SELECT currval(pg_get_serial_sequence('customer_order','id')) INTO return_id;
		RETURN return_id;
	END;
$$ LANGUAGE plpgsql;

/*получение текущей роли -- используется менеджером при регистрации*/
CREATE OR REPLACE FUNCTION get_role (role_id INTEGER) RETURNS VARCHAR AS $$
  DECLARE 
	role_name VARCHAR(15);
  BEGIN
  	SELECT
		CASE role_id WHEN 1 THEN 'Manager'
					WHEN 2 THEN 'Waiter'
					WHEN 3 THEN 'Cook'
		END
		INTO role_name;
	RETURN role_name;
  END;
$$ LANGUAGE plpgsql;