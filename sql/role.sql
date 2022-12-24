DROP OWNED BY "Manager";
DROP OWNED BY "Waiter";
DROP OWNED BY "Cook";

DROP ROLE "Manager";
DROP ROLE "Waiter";
DROP ROLE "Cook";
DROP USER "Login";

CREATE ROLE "Manager";
CREATE ROLE "Waiter";
CREATE ROLE "Cook";
CREATE USER "Login" WITH PASSWORD 'f5234a478d8ae58ec8c0022b257cff89';

GRANT CONNECT ON DATABASE "Restaurant" TO "Login";
GRANT CONNECT ON DATABASE "Restaurant" TO "Manager";
GRANT CONNECT ON DATABASE "Restaurant" TO "Waiter";
GRANT CONNECT ON DATABASE "Restaurant" TO "Cook";

GRANT SELECT ON account, employee TO "Login";

GRANT ALL ON ALL TABLES IN SCHEMA public TO "Manager";
GRANT USAGE, SELECT ON ALL sequences IN SCHEMA public TO "Manager";
GRANT SELECT ON waiter_day, total_day, waiter_week, total_week TO "Manager";

GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public to "Waiter";
GRANT SELECT ON role_classifier, dish_classifier, payment_classifier, employee TO "Waiter";
GRANT SELECT, INSERT ON receipt TO "Waiter";
GRANT SELECT, UPDATE ON dish, restaurant_table TO "Waiter";
GRANT SELECT, INSERT, UPDATE ON customer_order TO "Waiter";
GRANT DELETE, SELECT, INSERT ON ordered_dish TO "Waiter";

GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public to "Cook";
GRANT SELECT ON role_classifier, restaurant_table, dish_classifier  TO "Cook";
GRANT SELECT, INSERT, UPDATE ON ordered_dish TO "Cook";
GRANT SELECT, UPDATE ON dish TO "Cook";
GRANT SELECT, INSERT, UPDATE ON ordered_dish TO "Waiter";

ALTER TABLE ordered_dish ENABLE ROW LEVEL SECURITY;
ALTER TABLE customer_order ENABLE ROW LEVEL SECURITY;

CREATE POLICY ordered_dish_policy_manager ON ordered_dish TO "Manager" 
    USING (true) 
    WITH CHECK (true);

CREATE POLICY ordered_dish_policy_select ON ordered_dish 
    FOR SELECT 
    USING (true);

CREATE POLICY ordered_dish_policy_update ON ordered_dish 
    FOR UPDATE to "Cook"
    USING (true);

CREATE POLICY ordered_dish_policy_delete ON ordered_dish 
    FOR DELETE
    USING (
        (SELECT login FROM employee WHERE id = 
            (SELECT waiter_id FROM customer_order WHERE id = ordered_dish.order_id)
        ) = current_user);

CREATE POLICY ordered_dish_policy_insert ON ordered_dish 
    FOR INSERT
    WITH CHECK (true);

CREATE POLICY customer_order_policy_manager ON customer_order TO "Manager"
    USING (true) 
    WiTH CHECK (true);

CREATE POLICY customer_order_policy_select ON customer_order 
    FOR SELECT 
    USING(true);

CREATE POLICY customer_order_policy_update ON customer_order 
    FOR UPDATE
    USING((SELECT login FROM employee WHERE id = waiter_id) = current_user);

CREATE POLICY customer_order_policy_insert ON customer_order 
    FOR INSERT 
    WITH CHECK(true);