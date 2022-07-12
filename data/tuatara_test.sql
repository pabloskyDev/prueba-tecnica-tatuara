/*DROP DATABASE tuatara_test;*/
CREATE DATABASE tuatara_test;
USE tuatara_test;

/*DROP TABLE usuarios;*/
CREATE TABLE usuarios (
	documento VARCHAR(20) PRIMARY KEY,
    nombre_completo VARCHAR(40),
    apellidos VARCHAR(60),
    email VARCHAR(100),
    f_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	f_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

SELECT * FROM usuarios;

/*

INSERT INTO usuarios
(documento, tipo_documento, nombre_completo, apellidos, email, telefono)
VALUES
('1213656323', 'cc', 'Fernando', 'Vargas Lozano', 'fer.lo@gmail-1.com', '3125236956'),
('45236895', 'cc', 'Sofia', 'Cardenas Toro', 'sofi.toro@gmail-2.com', '5236896'),
('1000235899', 'ti', 'Laura Maria', 'Nabarrez Lopez', 'mari.lau@gmail-3.com', '3002135589'),
('78569236', 'cc', 'Juan Camilo', 'Gonzales Urrutia', 'cami.urru@gmail-4.com', '3192847500')

*/