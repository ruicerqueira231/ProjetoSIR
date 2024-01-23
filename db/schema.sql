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
    FOREIGN KEY (id_category) REFERENCES tb_category(id_category)
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
    FOREIGN KEY (id_event, id_user) REFERENCES tb_participacao(id_event, id_user) On DELETE CASCADE
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