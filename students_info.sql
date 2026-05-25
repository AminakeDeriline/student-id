USE id;
CREATE TABLE students_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255),
    name VARCHAR(255),
    matricule VARCHAR(255),
    level INT,
    sex VARCHAR(20),
    department VARCHAR(255),
    photo_path LONGBLOB,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
