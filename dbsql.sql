CREATE DATABASE IF NOT EXISTS project_php;

use project_php;

CREATE TABLE IF NOT EXISTS users(
    id int PRIMARY KEY AUTO_INCREMENT,
    email varchar(30) UNIQUE NOT NULL,
    passwd varchar(70) NOT NULL,
    picture varchar(50),
    type bit NOT NULL
);

CREATE TABLE IF NOT EXISTS terms (
    term decimal(1) PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS levels (
    lvl decimal(1) PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS subjects(
    id int PRIMARY KEY,
    subject varchar(15) UNIQUE NOT NULL,
    
    lvl decimal(1) NOT NULL,
    FOREIGN KEY (lvl) REFERENCES levels(lvl),
    
    term decimal(1) NOT NULL,
    FOREIGN KEY (term) REFERENCES terms(term)
);

CREATE TABLE IF NOT EXISTS guardian(
    id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(40) NOT Null,
    phone varchar(9) UNIQUE NOT Null,
    address varchar(40)    
);

CREATE TABLE IF NOT EXISTS student(
    id int PRIMARY KEY AUTO_INCREMENT,
    fname varchar(15) NOT Null,
    lname varchar(15) NOT Null,
    birthday DATE NOT Null,
    
    user_id int UNIQUE NOT Null,
    FOREIGN KEY(user_id) REFERENCES users(id),
    
    state decimal(1) NOT Null,
    
    guardian_id int NOT Null,
    FOREIGN KEY(guardian_id) REFERENCES guardian(id)
);

CREATE TABLE IF NOT EXISTS degrees(
    student_id int NOT Null,
    FOREIGN KEY(student_id) REFERENCES student(id),
    
    subject_id int NOT Null,
    FOREIGN KEY(subject_id) REFERENCES subjects(id),
    
    degree int CHECK(degree >= 0 AND degree<=100)
); 

CREATE TABLE IF NOT EXISTS staff (
    id int PRIMARY KEY AUTO_INCREMENT,
    fname varchar(30) NOT Null,
    lname varchar(30) NOT Null,
    phone int UNIQUE,
    address varchar(60),
    salary int,
    type decimal(1) NOT Null,
    Educational_level decimal(1) NOT Null
);
 
INSERT INTO staff VALUES (1,'Abdulbari','Al-Haimi',773445324,'Yemen,Sanaa,Sawan',150000,6,1);
INSERT INTO staff VALUES (1,'Moneer','Al-Jomary',77344532,'Yemen,Sanaa,Sawan',190000,6,1)
/* Alter */
ALTER TABLE student AUTO_INCREMENT = 230001;
ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE guardian AUTO_INCREMENT = 1;
ALTER TABLE staff AUTO_INCREMENT = 1;

/*
// Inserting //

password = 
    admin = 333
    230001 = 155
    230002 = 133
*/
INSERT INTO users (email,passwd,picture,type) VALUES ("admin@gmail.com", "$2y$10$Aboihz69U1TSrinKnHVCe.Z9Ds52.nbVvyFI51C1SCo5Jfu34Du6e" ,"/pic/ff.png",1);
INSERT INTO users (email,passwd,picture,type) VALUES ("230001@gmail.com", "$2y$10$4fvVaLXAtRlFlBkYyg/cPu9VkngnZ.UOpI5jTVgxlU8SW60M62bRC" ,"/pic/ffd.png",0);
INSERT INTO users (email,passwd,picture,type) VALUES ("230002@gmail.com", "$2y$10$yrEnOzEMezwP9ymgswMJuOnpbHjxYKit9ImJDqFDC7ROBli9rg3l2" ,"/pic/drw.png",0);

INSERT INTO terms VALUES (1);
INSERT INTO terms VALUES (2);

INSERT INTO levels VALUES (1);
INSERT INTO levels VALUES (2);
INSERT INTO levels VALUES (3);

INSERT INTO subjects VALUES (101 , "Math-1" , 1 , 1);
INSERT INTO subjects VALUES (102 , "Math-2" , 1 , 2);
INSERT INTO subjects VALUES (103 , "Math-3" , 2 , 1);
INSERT INTO subjects VALUES (104 , "Math-4" , 2 , 2);
INSERT INTO subjects VALUES (105 , "Math-5" , 3 , 1);
INSERT INTO subjects VALUES (106 , "Math-6" , 3 , 2);
INSERT INTO subjects VALUES (201 , "Science-1" , 1 , 1);
INSERT INTO subjects VALUES (202 , "Science-2" , 1 , 2);
INSERT INTO subjects VALUES (203 , "Science-3" , 2 , 1);
INSERT INTO subjects VALUES (204 , "Science-4" , 2 , 2);
INSERT INTO subjects VALUES (205 , "Science-5" , 3 , 1);
INSERT INTO subjects VALUES (206 , "Science-6" , 3 , 2);

INSERT INTO guardian (name , phone , address) VALUES ("Hassan Youssef" , "771884062" , "Yemen-Sanaa-Sawan");
INSERT INTO guardian (name , phone , address) VALUES ("Mohammed Saleh" , "779550229" , "Yemen-Sanaa-Sawan");

INSERT INTO student (fname,lname,birthday,user_id,state,guardian_id) VALUES ("Haroon","Taher",'2002-7-17',2,1,1);
INSERT INTO student (fname,lname,birthday,user_id,state,guardian_id) VALUES ("Mazen","Al-Emad",'1999-12-5',3,1,2);

INSERT INTO degrees VALUES (230001,101,95);
INSERT INTO degrees VALUES (230001,102,85);
INSERT INTO degrees VALUES (230001,103,90);
INSERT INTO degrees VALUES (230001,201,80);
INSERT INTO degrees VALUES (230001,202,85);
INSERT INTO degrees VALUES (230001,203,75);

INSERT INTO degrees VALUES (230002,101,80);
INSERT INTO degrees VALUES (230002,102,85);
INSERT INTO degrees VALUES (230002,103,88);
INSERT INTO degrees VALUES (230002,201,75);
INSERT INTO degrees VALUES (230002,202,82);
INSERT INTO degrees VALUES (230002,203,84);