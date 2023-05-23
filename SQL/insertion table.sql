INSERT INTO `categorie` (`id_Cat`, `nom_cat`) VALUES
(1, 'java'),
(2, 'php'),
(3, 'html'),
(4, 'css'),
(5, 'divers');

INSERT INTO compte(nom,prenom,statut) VALUES
("dupont","gerard","0"),
("dupond","gerard","0");

INSERT INTO `question` (`id_question`, `titre`, `contenu`, `id_compte`, `id_cat`, `verif`) VALUES
(1, 'titretest', 'Je me demande simplement si je peux remplir la base', 1, 1, 0),
(2, 'Rendu', 'Quelle est la date limite pour le rendu ?', 1, 1, 0),
(3, 'Flexbox', 'J\'ai pas compris les flexbox', 1, 1, 0),
(4, 'Modèle à évènements', 'Comment et dans quels cas utiliser le modèle à évènements en java ?', 1, 1, 1);
