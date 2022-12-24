DROP VIEW waiter_week;
DROP VIEW waiter_day;
DROP VIEW total_week;
DROP VIEW total_day;

CREATE VIEW waiter_week AS 
	SELECT first_name, last_name, sum(total) 
	FROM receipt 
	INNER JOIN customer_order ON id = order_id INNER JOIN employee ON customer_order.waiter_id = employee.id 
	WHERE status = true AND current_date - date_created  <= 7 GROUP BY first_name, last_name ORDER BY sum DESC;

CREATE VIEW waiter_day AS
	SELECT first_name, last_name, sum(total) FROM receipt 
	INNER JOIN customer_order ON id = order_id INNER JOIN employee ON customer_order.waiter_id = employee.id 
	WHERE status = true AND date_created = current_date GROUP BY first_name, last_name ORDER BY sum DESC;

CREATE VIEW total_week AS
	SELECT sum(total) 
	FROM receipt 
	INNER JOIN customer_order ON id = order_id 
	WHERE status = true AND current_date - date_created  <= 7;

CREATE VIEW total_day AS
	SELECT sum(total) 
	FROM receipt 
	INNER JOIN customer_order ON id = order_id 
	WHERE status = true AND date_created = current_date;