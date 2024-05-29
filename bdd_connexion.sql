CREATE DATABASE ece_in;

USE ece_in;

CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    pseudo VARCHAR(30) NOT NULL
);

INSERT INTO users (email, pseudo) VALUES 
('lukas.levy@edu.ece.fr', 'Lukas_LEVY'),
('manon.loirat@edu.ece.fr', 'Manon_LOIRAT'),
('elia.sylvestre@edu.ece.fr', 'Elia_SYLVESTRE'),
('djaze.guerna@edu.ece.fr', 'Djaze_GUERNA');



CREATE TABLE formations_projets (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT(6) UNSIGNED,
    type ENUM('formation', 'projet') NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id)
);