CREATE TABLE tb_user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(50),
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    image_url VARCHAR(255),
    security_question VARCHAR (255)
);


CREATE TABLE tb_category (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255)
);

CREATE TABLE tb_event (
    id_event INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    localizacao VARCHAR(255),
    date_event DATE NOT NULL,
    hora TIME,
    id_category INT,
    FOREIGN KEY (id_category) REFERENCES tb_category(id_category),
    image_path VARCHAR(250) 
);

CREATE TABLE tb_participacao (
    id_user INT,
    id_event INT,
    PRIMARY KEY (id_user, id_event),
    FOREIGN KEY (id_user) REFERENCES tb_user(id_user),
    FOREIGN KEY (id_event) REFERENCES tb_event(id_event)
);

CREATE TABLE tb_note (
    id_note INT AUTO_INCREMENT PRIMARY KEY,
    note TEXT,
    date_note DATE NOT NULL,
    hora_note TIME NOT NULL,
    id_user INT,
    id_event INT,
    FOREIGN KEY (id_user, id_event) REFERENCES tb_participacao (id_user, id_event)
);

CREATE TABLE tb_attachement (
    id_attachement INT AUTO_INCREMENT PRIMARY KEY,
    attachement varchar(250) NOT NULL,
    id_event INT,
    id_user INT,
    FOREIGN KEY (id_event, id_user) REFERENCES tb_participacao(id_event, id_user) ON DELETE CASCADE
);

CREATE TABLE tb_invite (
    id_invite INT AUTO_INCREMENT PRIMARY KEY,
    estado VARCHAR(255),
    id_user INT,
    id_user_convidado INT,
    id_event INT,
    FOREIGN KEY (id_user) REFERENCES tb_user(id_user),
    FOREIGN KEY (id_user_convidado) REFERENCES tb_user(id_user),
    FOREIGN KEY (id_event) REFERENCES tb_event(id_event) ON DELETE CASCADE 
);

ALTER TABLE tb_event
ADD COLUMN id_user_creator INT,
ADD FOREIGN KEY (id_user_creator) REFERENCES tb_user(id_user);

CREATE TABLE password_reset (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE tb_participacao
ADD CONSTRAINT fk_event
FOREIGN KEY (id_event) REFERENCES tb_event(id_event)
ON DELETE CASCADE;

CREATE TABLE tb_admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE statistics (
    stat_name VARCHAR(50) NOT NULL,
    stat_value INT NOT NULL,
    PRIMARY KEY (stat_name)
);

INSERT INTO statistics (stat_name, stat_value) VALUES ('landing_page_visits', 0);
INSERT INTO statistics (stat_name, stat_value) VALUES ('accounts_created', 0);

INSERT INTO tb_user (name, email, phone, username, password, image_url, security_question) VALUES 
('Fernando', 'frocha.tts@gmail.com', '911552841', 'fernando', '$2y$10$NVE3tWAMiJOJfMLbtmFWd.giIdq9y9w0MOoDcXeTXpAHduCix4GAe', 'https://i.imgur.com/BDnPUIt.png', '2910'),
('Rui', 'ruicerqueira647@gmail.com', '911223344', 'rui', '$2y$10$DWWb75OedUIVNfH.4BIx4eA.Asozeg4slL0yc2jIf6QssQ8H/KbvO', 'https://i.imgur.com/RH5wV6P.png', '647'),
('Perla', 'perla_yorkie@gmail.com', '911552841', 'perla', '$2y$10$NVE3tWAMiJOJfMLbtmFWd.giIdq9y9w0MOoDcXeTXpAHduCix4GAe', 'https://i.imgur.com/E08Cz8p.png', '2910'),
('John Doe1', 'johndoe1@example.com', '555-0101', 'john1', 'hashed_password1', 'https://i.imgur.com/XgbZdeA.png', 'What is your favorite color?'),
('Jane Doe2', 'janedoe2@example.com', '555-0202', 'jane2', 'hashed_password2', 'https://i.imgur.com/XgbZdeA.png', 'What was your first pet’s name?'),
('John Doe3', 'johndoe3@example.com', '555-0303', 'john3', 'hashed_password3', 'https://i.imgur.com/XgbZdeA.png', 'What is your mother’s maiden name?'),
('Jane Doe4', 'janedoe4@example.com', '555-0404', 'jane4', 'hashed_password4', 'https://i.imgur.com/XgbZdeA.png', 'What was the make of your first car?'),
('John Doe5', 'johndoe5@example.com', '555-0505', 'john5', 'hashed_password5', 'https://i.imgur.com/XgbZdeA.png', 'In what city were you born?'),
('Jane Doe6', 'janedoe6@example.com', '555-0606', 'jane6', 'hashed_password6', 'https://i.imgur.com/XgbZdeA.png', 'What high school did you attend?'),
('John Doe7', 'johndoe7@example.com', '555-0707', 'john7', 'hashed_password7', 'https://i.imgur.com/XgbZdeA.png', 'What is the name of your first school?'),
('Jane Doe8', 'janedoe8@example.com', '555-0808', 'jane8', 'hashed_password8', 'https://i.imgur.com/XgbZdeA.png', 'What is your favorite movie?'),
('John Doe9', 'johndoe9@example.com', '555-0909', 'john9', 'hashed_password9', 'https://i.imgur.com/XgbZdeA.png', 'What street did you grow up on?'),
('Jane Doe10', 'janedoe10@example.com', '555-1010', 'jane10', 'hashed_password10', 'https://i.imgur.com/XgbZdeA.png', 'What was the name of your first pet?'),
('John Doe11', 'johndoe11@example.com', '555-1111', 'john11', 'hashed_password11', 'https://i.imgur.com/XgbZdeA.png', 'What is your father’s middle name?'),
('Jane Doe12', 'janedoe12@example.com', '555-1212', 'jane12', 'hashed_password12', 'https://i.imgur.com/XgbZdeA.png', 'What is the name of your favorite teacher?'),
('John Doe13', 'johndoe13@example.com', '555-1313', 'john13', 'hashed_password13', 'https://i.imgur.com/XgbZdeA.png', 'What is your favorite team?'),
('Jane Doe14', 'janedoe14@example.com', '555-1414', 'jane14', 'hashed_password14', 'https://i.imgur.com/XgbZdeA.png', 'What was your childhood nickname?'),
('John Doe15', 'johndoe15@example.com', '555-1515', 'john15', 'hashed_password15', 'https://i.imgur.com/XgbZdeA.png', 'What is the name of your favorite childhood friend?'),
('Jane Doe16', 'janedoe16@example.com', '555-1616', 'jane16', 'hashed_password16', 'https://i.imgur.com/XgbZdeA.png', 'What was the first concert you attended?'),
('John Doe17', 'johndoe17@example.com', '555-1717', 'john17', 'hashed_password17', 'https://i.imgur.com/XgbZdeA.png', 'What was your dream job as a child?'),
('Jane Doe18', 'janedoe18@example.com', '555-1818', 'jane18', 'hashed_password18', 'https://i.imgur.com/XgbZdeA.png', 'What is your spouse’s middle name?'),
('John Doe19', 'johndoe19@example.com', '555-1919', 'john19', 'hashed_password19', 'https://i.imgur.com/XgbZdeA.png', 'What is your favorite book?'),
('Jane Doe20', 'janedoe20@example.com', '555-2020', 'jane20', 'hashed_password20', 'https://i.imgur.com/XgbZdeA.png', 'What is the name of the road you grew up on?');

INSERT INTO tb_admin (username, password)
VALUES ('admin', '$2y$10$VbWSJc8p7ss8G.V5xIq0TeJw5j6A5pQuR8dawJL/BGE8zFjQKmiHS');

INSERT INTO tb_category (category) VALUES ('Electronics');
INSERT INTO tb_category (category) VALUES ('Clothing');
INSERT INTO tb_category (category) VALUES ('Home and Garden');
INSERT INTO tb_category (category) VALUES ('Sports and Outdoors');
INSERT INTO tb_category (category) VALUES ('Health and Beauty');
INSERT INTO tb_category (category) VALUES ('Automotive');
INSERT INTO tb_category (category) VALUES ('Books and Literature');
INSERT INTO tb_category (category) VALUES ('Toys and Games');
INSERT INTO tb_category (category) VALUES ('Food and Grocery');
INSERT INTO tb_category (category) VALUES ('Jewelry and Accessories');
INSERT INTO tb_category (category) VALUES ('Furniture');
INSERT INTO tb_category (category) VALUES ('Pet Supplies');
INSERT INTO tb_category (category) VALUES ('Music and Instruments');
INSERT INTO tb_category (category) VALUES ('Art and Crafts');
INSERT INTO tb_category (category) VALUES ('Office and School Supplies');
INSERT INTO tb_category (category) VALUES ('Electronics Accessories');
INSERT INTO tb_category (category) VALUES ('Home Decor');
INSERT INTO tb_category (category) VALUES ('Outdoor Equipment');
INSERT INTO tb_category (category) VALUES ('Beauty and Personal Care');
INSERT INTO tb_category (category) VALUES ('Kitchen and Dining');