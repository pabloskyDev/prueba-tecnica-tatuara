DROP DATABASE if EXISTS tuatara_test;
CREATE DATABASE tuatara_test;
USE tuatara_test;

CREATE TABLE IF NOT EXISTS usuarios (
    id int(11) NOT NULL AUTO_INCREMENT,
	documento VARCHAR(20),
    nombre VARCHAR(40),
    apellidos VARCHAR(60),
    email VARCHAR(100),
    f_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	f_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)
