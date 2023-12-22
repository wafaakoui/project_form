CREATE DATABASE mabiblio;
CREATE TABLE TUtilisateur(
    Nom        varchar(50),
    Email      varchar(50) primary key,
    MotDePasse varchar(50),
    Droits     varchar(10)
);