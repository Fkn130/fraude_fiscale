CREATE TABLE Utilisateurs(
   id INT,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   adress_mail VARCHAR(50),
   identifiant VARCHAR(50),
   mot_de_passe VARCHAR(50),
   PRIMARY KEY(id)
);

CREATE TABLE Spectacteur(
   id INT,
   inscription VARCHAR(50),
   nb_place INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES Utilisateurs(id)
);

CREATE TABLE Admin(
   id INT,
   creer_event VARCHAR(50),
   organiser_event VARCHAR(50),
   planifier_event VARCHAR(50),
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES Utilisateurs(id)
);

CREATE TABLE Evenement(
   id INT,
   even_jeux_video VARCHAR(50),
   date_heure_even DATETIME,
   id_1 INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_1) REFERENCES Admin(id)
);

CREATE TABLE sinscire(
   id INT,
   id_1 INT,
   PRIMARY KEY(id, id_1),
   FOREIGN KEY(id) REFERENCES Evenement(id),
   FOREIGN KEY(id_1) REFERENCES Spectacteur(id)
);
