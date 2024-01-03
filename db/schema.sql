
CREATE TABLE tb_user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(50),
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    image_url VARCHAR(255)
);


CREATE TABLE tb_category (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255)
);

CREATE TABLE tb_event (
    id_event INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    localizacao VARCHAR(255),
    date_event DATE NOT NULL,
    hora_event TIME,
    id_category INT,
    FOREIGN KEY (id_category) REFERENCES tb_category(id_category)
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
    data DATE NOT NULL,
    id_user INT,
    id_event INT,
    FOREIGN KEY (id_user, id_event) REFERENCES tb_participacao (id_user, id_event)
);

CREATE TABLE tb_attachement (
    id_attachement INT AUTO_INCREMENT PRIMARY KEY,
    anexo BLOB NOT NULL,
    id_event INT,
    id_user INT,
    FOREIGN KEY (id_event, id_user) REFERENCES tb_participacao(id_event, id_user)
);

CREATE TABLE tb_invite (
    id_invite INT AUTO_INCREMENT PRIMARY KEY,
    estado VARCHAR(255),
    id_user INT,
    id_user_convidado INT,
    id_event INT,
    FOREIGN KEY (id_user) REFERENCES tb_user(id_user),
    FOREIGN KEY (id_user_convidado) REFERENCES tb_user(id_user),
    FOREIGN KEY (id_event) REFERENCES tb_event(id_event)
);
