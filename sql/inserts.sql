INSERT INTO dish_classifier (name) VALUES ('Супы'), ('Горячие блюда'), ('Салаты'), ('Десерты'), ('Безалкогольные напитки'), ('Алкогольные напитки');

INSERT INTO role_classifier (name) VALUES ('Менеждер'), ('Официант'), ('Повар');

INSERT INTO restaurant_table (capacity) VALUES (4), (2), (8), (6), (2), (4), (4), (2), (2), (4), (6), (8), (10), (4), (2), (2);

INSERT INTO dish (name, price, available, category_id) VALUES
('Буйабес', 1300, true, 1),
('Консоме', 1000, true, 1),
('Луковый суп', 1200, true, 1),

('Курица по-провански', 1800, true, 2),
('Шатобриан', 2100, true, 2),
('Жульен', 1700, true, 2),

('Марсель', 800, true, 3),
('Оливье',900, true, 3),
('Нисуаз', 700, true, 3),

('Клафути', 1500, true, 4),
('Крокембуш',1700, true, 4),
('Профитроли', 1400, true, 4),

('Чёрный чай', 1500, true, 5),
('Апельсиновый сок',1700, true, 5),
('Молочный коктейль', 1400, true, 5),

('Шампанское',1700, true, 6),
('Коньяк', 1400, true, 6),
('Вино', 1400, true, 6);
INSERT INTO payment_classifier (id, name) VALUES (1, 'Наличными'), (2, 'Картой'), (3, 'Переводом');

CALL new_employee ('magenta_square', 'SalmonUnderBlackChair', 'max', 'black', '+1234567890', 'maxblack@restaurant.local', 1);
CALL new_employee ('notorius_baesitter', 'DontEatYellowSnow', 'vasya', 'elizarov', '+1134467792', 'vasya@restaurant.local', 2);
CALL new_employee ('illustrious_oguzok', 'ShipTryedLayingEggs', 'max', 'lavrov', '+3125467798', 'lavrov@restaurant.local', 3);