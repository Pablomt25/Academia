CREATE DATABASE IF NOT EXISTS academia;
USE academia;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL
);


CREATE TABLE IF NOT EXISTS materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS pruebas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_materia INT NOT NULL,
    id_profesor INT NOT NULL,
    id_alumno INT NOT NULL,
    trimestre INT NOT NULL,
    nota DECIMAL(4,2),
    FOREIGN KEY (id_materia) REFERENCES materias(id),
    FOREIGN KEY (id_profesor) REFERENCES usuarios(id),
    FOREIGN KEY (id_alumno) REFERENCES usuarios(id)
);


CREATE TABLE IF NOT EXISTS padres_hijos (
    id_padre INT NOT NULL,
    id_hijo INT NOT NULL,
    PRIMARY KEY (id_padre, id_hijo),
    FOREIGN KEY (id_padre) REFERENCES usuarios(id),
    FOREIGN KEY (id_hijo) REFERENCES usuarios(id)
);





INSERT INTO usuarios (nombre, apellidos, email, password, rol) VALUES
('Administrador', '', 'admin@academia.com', 'admin', 'admin'),
('Profesor1', 'Apellido1', 'profesor1@academia.com', 'profesor1', 'profesor'),
('Profesor2', 'Apellido2', 'profesor2@academia.com', 'profesor2', 'profesor'),
('Padre1', 'Apellido3', 'padre1@academia.com', 'padre1', 'padre'),
('Alumno1', 'Apellido4', 'alumno1@academia.com', 'alumno1', 'alumno'),
('Alumno2', 'Apellido5', 'alumno2@academia.com', 'alumno2', 'alumno'),
('Padre2', 'Apellido6', 'padre2@academia.com', 'padre2', 'padre');

INSERT INTO materias (nombre) VALUES
('Diseño Web'),
('Entorno Cliente'),
('Entorno Servidor'),
('Despliegue de Aplicaciones Web'),
('Empresas');


INSERT INTO pruebas (id_materia, id_profesor, id_alumno, trimestre, nota) VALUES
(1, 2, 3, 1, 8.5), 
(2, 3, 4, 2, 7.2),   
(3, 4, 5, 1, 9.0),  
(4, 2, 3, 3, 6.5),   
(1, 4, 5, 2, 8.0);   

INSERT INTO padres_hijos (id_padre, id_hijo) VALUES
(4, 3),
(4, 5),
(6, 7);

