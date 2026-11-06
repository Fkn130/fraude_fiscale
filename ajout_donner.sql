INSERT INTO Utilisateurs (id, nom, prenom, adress_mail, identifiant, mot_de_passe) VALUES
(1, 'Dupont', 'Lucas', 'lucas.dupont@gmail.com', 'lucasdu59', 'mdp123'),
(2, 'Martin', 'Emma', 'emma.martin@gmail.com', 'emmamartin', 'emma456'),
(3, 'Bernard', 'Hugo', 'hugo.bernard@gmail.com', 'hugobernard', 'hugo789'),
(4, 'Petit', 'Lea', 'lea.petit@gmail.com', 'leapetit', 'lea123'),
(5, 'Robert', 'Nathan', 'nathan.robert@gmail.com', 'nathanr', 'nathan456'),
(6, 'Richard', 'Chloe', 'chloe.richard@gmail.com', 'chloer', 'chloe789'),
(7, 'Durand', 'Theo', 'theo.durand@gmail.com', 'theodurand', 'theo123'),
(8, 'Moreau', 'Ines', 'ines.moreau@gmail.com', 'inesm', 'ines456'),
(9, 'Simon', 'Enzo', 'enzo.simon@gmail.com', 'enzosimon', 'enzo789'),
(10, 'Laurent', 'Jade', 'jade.laurent@gmail.com', 'jadelaurent', 'jade123');

INSERT INTO Spectacteur (id, inscription, nb_place) VALUES
(3, 'Oui', 2),
(4, 'Oui', 1),
(5, 'Oui', 3),
(6, 'Oui', 2),
(7, 'Non', 0),
(8, 'Oui', 4),
(9, 'Oui', 1),
(10, 'Non', 0);

INSERT INTO Admin (id, creer_event, organiser_event, planifier_event) VALUES
(1, 'Oui', 'Oui', 'Oui'),
(2, 'Oui', 'Oui', 'Oui');

INSERT INTO Evenement (id, even_jeux_video, date_heure_even, id_1) VALUES
(1, 'Tournoi FIFA 26', '2026-11-15 14:00:00', 1),
(2, 'Tournoi Mario Kart World', '2026-11-20 15:00:00', 1),
(3, 'Competition Fortnite', '2026-11-25 16:00:00', 2),
(4, 'Tournoi League of Legends', '2026-12-01 13:00:00', 2),
(5, 'Competition Rocket League', '2026-12-05 14:30:00', 1),
(6, 'Tournoi Super Smash Bros', '2026-12-10 15:00:00', 2);

INSERT INTO sinscire (id, id_1) VALUES
(1, 3),
(1, 4),
(1, 5),
(2, 3),
(2, 6),
(2, 8),
(3, 4),
(3, 7),
(3, 9),
(4, 5),
(4, 8),
(5, 6),
(5, 10),
(6, 3),
(6, 9);