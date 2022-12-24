/*Создание нового работника --  процедура менеджера*/
CREATE OR REPLACE PROCEDURE new_employee (login VARCHAR(64), password VARCHAR, first_name VARCHAR(128), last_name VARCHAR(128), phone_number VARCHAR(15),  email VARCHAR(128), role_id INTEGER) AS $$
	BEGIN
		SELECT MD5(password) INTO password;
    CALL new_user(login, password, role_id);
		EXECUTE format('INSERT INTO account (login, password) VALUES (%L, %L)', login, password);
		EXECUTE format('INSERT INTO employee (first_name, last_name, phone_number, email, role_id, login) VALUES (%L, %L, %L, %L, %L, %L)', first_name, last_name, phone_number, email, role_id, login);
	END;
$$ LANGUAGE plpgsql;

/*Создание нового пользователя в БД (сопутсвует созданию нового работника)*/
CREATE OR REPLACE PROCEDURE new_user (username VARCHAR(64), password VARCHAR(32), role_id INTEGER) AS $$
  DECLARE 
  	role_name VARCHAR(15);
  BEGIN
  	SELECT get_role(role_id) INTO role_name;
    EXECUTE format('CREATE USER %I IN ROLE %I PASSWORD %L', username, role_name, password);
	IF role_id = 1 THEN EXECUTE format('ALTER USER %I CREATEROLE', username); END IF;
  END;
$$ LANGUAGE plpgsql;

/*добавление нового блюда -- процедура менеджера*/
CREATE OR REPLACE PROCEDURE new_dish (category INTEGER, name VARCHAR(250), price NUMERIC) AS $$
	BEGIN
		EXECUTE format('INSERT INTO dish (category_id, name, price, available) VALUES (%L, %L, %L, %L)', category, name, price, true);
	END;
$$ LANGUAGE plpgsql;

/*заполнение таблицы ordered_dish (сопутствует добавлению заказа) -- процедура официанта*/
CREATE OR REPLACE PROCEDURE fill_ordered_dish (order_id INTEGER, dish_id INTEGER) AS $$
	BEGIN
		EXECUTE format('INSERT INTO ordered_dish (order_id, dish_id, ready) VALUES (%L, %L, %L)', order_id, dish_id, false);
	END;
$$ LANGUAGE plpgsql;

/*создание чека -- процедура официанта*/
CREATE OR REPLACE PROCEDURE close_order (order_id INTEGER, total INTEGER, payment INTEGER) AS $$
	BEGIN
		EXECUTE format('INSERT INTO receipt (order_id, date_closed, time_close, total, payment_type_id) VALUES (%L, %L, %L, %L, %L)', order_id, CURRENT_DATE, CURRENT_TIME(0), total, payment);
	END;
$$ LANGUAGE plpgsql;

/*увольнение работника -- процедура менеджера*/
CREATE OR REPLACE PROCEDURE fire_employee (id INTEGER, emp_state BOOLEAN) AS $$
  BEGIN
    EXECUTE format('UPDATE employee SET is_employed = %L WHERE id = %L', emp_state, id);
  END;
$$ LANGUAGE plpgsql;

/*изменение зарплаты -- процедура менеджера*/
CREATE OR REPLACE PROCEDURE change_salary (id INTEGER, salary INTEGER) AS $$
  BEGIN
    EXECUTE format('update employee set salary = %L where id = %L', salary, id);
  END;
$$ LANGUAGE plpgsql;

/*изменение статуса готовности еды -- процедура повара*/
CREATE OR REPLACE PROCEDURE change_status_dish (dish_id INTEGER) AS $$
  BEGIN
    IF (SELECT available FROM dish WHERE id = dish_id) = true
    THEN
      UPDATE dish SET available = false WHERE id = dish_id;
    ELSE
      UPDATE dish set available = true WHERE id = dish_id;
    END IF;
  END;
$$ LANGUAGE plpgsql;