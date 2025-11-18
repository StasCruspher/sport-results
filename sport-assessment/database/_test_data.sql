INSERT INTO exercise (id, exercise_name, exercise_desc) VALUES
(1, '№1', 'Вправа 1'),
(2, '№2', 'Вправа 2'),
(3, '№3', 'Вправа 3'),
(4, '№4', 'Вправа 4');

INSERT INTO unit (id, unit_name) VALUES
(1, 'Підрозділ А'),
(2, 'Підрозділ Б'),
(3, 'Підрозділ В'),
(4, 'Підрозділ Г');

INSERT INTO age_group (age_group_number, description, gender) VALUES
(1, '18-25', 'чоловік'),
(2, '26-30', 'чоловік'),
(3, '31-35', 'чоловік'),
(4, '36-40', 'чоловік'),
(1, '18-25', 'жінка'),
(2, '26-30', 'жінка'),
(3, '31-35', 'жінка'),
(4, '36-40', 'жінка');

INSERT INTO category (category_number, description) VALUES
(1, 'Офіцери'),
(2, 'Сержанти'),
(3, 'Солдати'),
(4, 'Резервісти'),
(5, 'Контрактники'),
(6, 'Курсант'),
(7, 'Інструктор'),
(8, 'Снайпер'),
(9, 'Інженер'),
(10, 'Медик');

INSERT INTO mil_rank (name) VALUES
('Солдат'),
('Старший солдат'),
('Молодший сержант');

INSERT INTO participant (fullname, mil_rank_id, gender, badge_number, category_id, age_group_id, unit_id) VALUES
('Іван Петренко', (SELECT id FROM mil_rank WHERE name = 'Солдат'), 'чоловік', 1001, 1, 1, 1),
('Олег Сидорчук', (SELECT id FROM mil_rank WHERE name = 'Солдат'), 'чоловік', 1002, 1, 1, 1),
('Андрій Мельник', (SELECT id FROM mil_rank WHERE name = 'Солдат'), 'чоловік', 1003, 1, 1, 1);

insert into requirement(exercise_id, result, point, gender) values
((select id from exercise where exercise_name = '№1'), 7.10, 50,'чоловік'),
((select id from exercise where exercise_name = '№1'), 6.90, 45,'чоловік'),
((select id from exercise where exercise_name = '№1'), 6.70, 40,'чоловік'),
((select id from exercise where exercise_name = '№1'), 6.50, 35,'чоловік'),
((select id from exercise where exercise_name = '№1'), 6.30, 33,'чоловік'),
((select id from exercise where exercise_name = '№1'), 6.10, 31,'чоловік'),
((select id from exercise where exercise_name = '№1'), 5.90, 29,'чоловік'),
((select id from exercise where exercise_name = '№1'), 5.70, 27,'чоловік'),
((select id from exercise where exercise_name = '№1'), 5.50, 25,'чоловік'),
((select id from exercise where exercise_name = '№1'), 5.30, 23,'чоловік'),
((select id from exercise where exercise_name = '№1'), 5.10, 21,'чоловік'),
((select id from exercise where exercise_name = '№1'), 5.00, 18,'чоловік'),
((select id from exercise where exercise_name = '№1'), 4.80, 15,'чоловік'),
((select id from exercise where exercise_name = '№1'), 4.60, 13,'чоловік'),
((select id from exercise where exercise_name = '№1'), 4.40, 11,'чоловік'),
((select id from exercise where exercise_name = '№1'), 4.00, 9,'чоловік'),
((select id from exercise where exercise_name = '№1'), 3.80, 7,'чоловік');

INSERT INTO requirement(exercise_id, result, point, gender) VALUES
((SELECT id FROM exercise WHERE exercise_name = '№2'), 7.10, 50, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 6.90, 45, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 6.70, 40, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 6.50, 35, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 6.30, 33, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 6.10, 31, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 5.90, 29, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 5.70, 27, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 5.50, 25, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 5.30, 23, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 5.10, 21, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 5.00, 18, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 4.80, 15, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 4.60, 13, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 4.40, 11, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 4.00, 9, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№2'), 3.80, 7, 'чоловік');

INSERT INTO requirement(exercise_id, result, point, gender) VALUES
((SELECT id FROM exercise WHERE exercise_name = '№3'), 7.10, 50, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 6.90, 45, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 6.70, 40, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 6.50, 35, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 6.30, 33, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 6.10, 31, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 5.90, 29, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 5.70, 27, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 5.50, 25, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 5.30, 23, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 5.10, 21, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 5.00, 18, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 4.80, 15, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 4.60, 13, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 4.40, 11, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 4.00, 9, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№3'), 3.80, 7, 'чоловік');

INSERT INTO requirement(exercise_id, result, point, gender) VALUES
((SELECT id FROM exercise WHERE exercise_name = '№4'), 7.10, 50, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 6.90, 45, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 6.70, 40, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 6.50, 35, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 6.30, 33, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 6.10, 31, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 5.90, 29, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 5.70, 27, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 5.50, 25, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 5.30, 23, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 5.10, 21, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 5.00, 18, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 4.80, 15, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 4.60, 13, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 4.40, 11, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 4.00, 9, 'чоловік'),
((SELECT id FROM exercise WHERE exercise_name = '№4'), 3.80, 7, 'чоловік');

INSERT INTO score (unit_id, exercise_count, date) VALUES
((SELECT id FROM unit WHERE unit_name = 'Підрозділ А'), 4, '2025-10-01');

INSERT INTO score_exercise (score_id, exercise_id) VALUES
((SELECT id FROM score), (SELECT id FROM exercise WHERE exercise_name = '№1')),
((SELECT id FROM score), (SELECT id FROM exercise WHERE exercise_name = '№2')),
((SELECT id FROM score), (SELECT id FROM exercise WHERE exercise_name = '№3')),
((SELECT id FROM score), (SELECT id FROM exercise WHERE exercise_name = '№4'));

INSERT INTO result (score_id, participant_id) VALUES
((SELECT id FROM score), (SELECT id FROM participant WHERE fullname = 'Іван Петренко')),
((SELECT id FROM score), (SELECT id FROM participant WHERE fullname = 'Олег Сидорчук')),
((SELECT id FROM score), (SELECT id FROM participant WHERE fullname = 'Андрій Мельник'));

INSERT INTO phys_fitness_requirement (age_group_id, category_id, gender, exercise_threshold, exercise_count, total_points, result) VALUES
((SELECT id FROM age_group WHERE age_group_number = 1 AND gender = 'чоловік'), (SELECT id FROM category WHERE category_number = 1), 'чоловік', 15, 4, 60, 3),
((SELECT id FROM age_group WHERE age_group_number = 1 AND gender = 'чоловік'), (SELECT id FROM category WHERE category_number = 1), 'чоловік', 15, 4, 75, 4),
((SELECT id FROM age_group WHERE age_group_number = 1 AND gender = 'чоловік'), (SELECT id FROM category WHERE category_number = 1), 'чоловік', 15, 4, 90, 5);
