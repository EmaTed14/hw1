create database hw1;
use hw1;

CREATE TABLE utenti (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255),
  cognome VARCHAR(255),
  data_nascita DATE,
  sesso VARCHAR(20),
  foto_profilo VARCHAR(255),
  username VARCHAR(255),
  email VARCHAR(255),
  password VARCHAR(255)
);


CREATE TABLE ricette (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  nome_ricetta VARCHAR(255) NOT NULL,
  foto_ricetta VARCHAR(255) NOT NULL,
  ingredienti TEXT NOT NULL,
  procedimento TEXT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES utenti(id)
);


CREATE TABLE preferiti (
    id integer primary key auto_increment,
    user integer not null,
    content json
) Engine = InnoDB;


CREATE TABLE like_post (
  id INT(11) NOT NULL AUTO_INCREMENT,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  stato VARCHAR(10),
  PRIMARY KEY (id)
);


