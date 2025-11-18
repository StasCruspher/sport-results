CREATE DATABASE sport_assessment;
USE sport_assessment;


-- Вправи - основна сутність, має зберігатись запис після видалення для перегляду, але не для запису
CREATE TABLE exercise (
    id INTEGER AUTO_INCREMENT,
    exercise_name VARCHAR(6) NOT NULL,
    exercise_desc TEXT NOT NULL,
    deleted boolean NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id)
);

-- Підрозділ - основна сутність, має зберігатись запис після видалення для перегляду, але не для запису
CREATE TABLE unit (
    id INTEGER AUTO_INCREMENT,
    unit_name VARCHAR(200) NOT NULL,
    deleted boolean NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id)
);

-- Вікова група - основна сутність, має зберігатись запис після видалення для перегляду, але не для запису
CREATE TABLE age_group (
    id INTEGER AUTO_INCREMENT,
    age_group_number INTEGER NOT NULL,
    gender ENUM('чоловік', 'жінка') NOT NULL,
    description TEXT NOT NULL,
    deleted boolean NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id),
    UNIQUE KEY 'age_group_number_gender'(age_group_number, gender)
);

-- Категорія - основна сутність, має зберігатись запис після видалення для перегляду, але не для запису
CREATE TABLE category (
    id INTEGER AUTO_INCREMENT,
    category_number INTEGER NOT NULL,
    deleted boolean NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id)
);

-- Військове звання - основна сутність, має зберігатись запис після видалення для перегляду, але не для запису
CREATE TABLE mil_rank (
    id INTEGER AUTO_INCREMENT,
    name VARCHAR(250) NOT NULL,
    deleted boolean NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id)
);

-- Учень - основна сутність, має зберігатись запис після видалення для перегляду, але не для запису
CREATE TABLE participant (
    id INTEGER AUTO_INCREMENT,
    fullname VARCHAR(200) NOT NULL,
    mil_rank_id INTEGER NOT NULL,
    gender ENUM('чоловік', 'жінка') NOT NULL,
    badge_number INTEGER,
    category_id INTEGER NOT NULL,
    age_group_id INTEGER NOT NULL,
    unit_id INTEGER NOT NULL,
    deleted boolean NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id),
    FOREIGN KEY (unit_id) REFERENCES unit(id),
    FOREIGN KEY (category_id) REFERENCES category(id),
    FOREIGN KEY (age_group_id) REFERENCES age_group(id),
    FOREIGN KEY (mil_rank_id) REFERENCES mil_rank (id)
);

-- Норматив для вправи - залежна сутність, існує тільки для розрахунків балу для вправи, має повністю видалятись при "видалені" вправи (сама вправа при цьому залишається у БД)
CREATE TABLE requirement (
    id INTEGER AUTO_INCREMENT,
    exercise_id INTEGER NOT NULL,
    result DECIMAL(7,2) NOT NULL,
    point INTEGER NOT NULL,
    gender ENUM('чоловік', 'жінка') NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (exercise_id) REFERENCES exercise(id)
);

-- Залік - основна сутність, має зберігатись запис після видалення для перегляду, але не для запису
CREATE TABLE score (
    id INTEGER AUTO_INCREMENT,
    unit_id INTEGER NOT NULL,
    exercise_count INTEGER NOT NULL,
    date DATE NOT NULL,
    deleted boolean NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id),
    FOREIGN KEY (unit_id) REFERENCES unit(id)
);

-- Перелік вправ для заліку - залежна сутність, також як і сам залік, має залишатись у БД і не видалятись
CREATE TABLE score_exercise (
    id INTEGER AUTO_INCREMENT,
    score_id INTEGER NOT NULL,
    exercise_id INTEGER NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (score_id) REFERENCES score (id),
    FOREIGN KEY (exercise_id) REFERENCES exercise (id)
);

-- Результат складання заліку - залежна сутність, має не видалятись як і сам залік та учень
CREATE TABLE result (
    id INTEGER AUTO_INCREMENT,
    score_id INTEGER NOT NULL,
    participant_id INTEGER NOT NULL,
    point_sum INTEGER,
    phys_fitness_point INTEGER,
    PRIMARY KEY (id),
    FOREIGN KEY (score_id) REFERENCES score(id),
    FOREIGN KEY (participant_id) REFERENCES participant(id)
);

-- Результат виконання вправи у заліку - залежна сутність, має не видалятись як і сам залік та вправа
CREATE TABLE result_exercise (
    id INTEGER AUTO_INCREMENT,
    result_id INTEGER NOT NULL,
    exercise_id INTEGER NOT NULL,
    result DECIMAL(7,2) NOT NULL,
    point INTEGER NOT NULL,
    PRIMARY KEY (id)
);

-- Вимоги - основна сутність, але існує тільки для розрахунків загальної оцінки заліку, має видалятись
CREATE TABLE phys_fitness_requirement (
    id INTEGER AUTO_INCREMENT,
    age_group_id INTEGER NOT NULL,
    category_id INTEGER NOT NULL,
    gender ENUM('чоловік', 'жінка') NOT NULL,
    exercise_threshold INTEGER NOT NULL,
    exercise_count INTEGER NOT NULL,
    total_points INTEGER NOT NULL,
    result INTEGER NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (age_group_id) REFERENCES age_group (id),
    FOREIGN KEY (category_id) REFERENCES category (id)
);
