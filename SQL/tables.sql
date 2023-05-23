
--
drop table if exists reponse;
drop table if exists log_rep;
drop table if exists question;
drop table if EXISTS categorie;

drop table if exists compte;



CREATE TABLE `categorie` (
  `id_Cat` int PRIMARY KEY NOT NULL,
  `nom_cat` varchar(250) DEFAULT NULL
);

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_Cat`, `nom_cat`) VALUES
(1, 'java'),
(2, 'php'),
(3, 'html'),
(4, 'css'),
(5, 'divers');

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id_compte` int PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `nom` varchar(250) DEFAULT NULL,
  `prenom` varchar(250) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Structure de la table `log_rep`
--

CREATE TABLE `log_rep` (
  `id_compte` int DEFAULT NULL,
  `id_question` int DEFAULT NULL,
  `date_rep` date DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id_question` int PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `titre` varchar(250) DEFAULT NULL,
  `contenu` varchar(250) DEFAULT NULL,
  `id_compte` int(11) DEFAULT NULL,
  `id_cat` int DEFAULT NULL,
  `verif` tinyint(1) DEFAULT NULL
);

--
-- Déchargement des données de la table `question`
--


-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id_rep` int  PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `id_question` int(11) NOT NULL,
  `contenu_rep` varchar(2000) DEFAULT NULL
);


--
-- Index pour la table `compte`
--

-- Index pour la table `log_rep`

--

ALTER TABLE `log_rep`
  ADD CONSTRAINT fk_log_rep_compte FOREIGN KEY (`id_compte`) REFERENCES compte(`id_compte`),
  ADD CONSTRAINT fk_log_rep_question FOREIGN KEY (`id_question`) REFERENCES question(`id_question`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT fk_question_compte FOREIGN KEY (`id_compte`) REFERENCES compte(`id_compte`),
  ADD CONSTRAINT fk_question_categorie FOREIGN KEY (`id_cat`) REFERENCES categorie(`id_cat`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT fk_reponse_question FOREIGN KEY (`id_question`) REFERENCES question(`id_question`);


