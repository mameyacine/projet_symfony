-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 15 avr. 2024 à 08:45
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`id`, `theme_id`, `name`) VALUES
(1, 1, 'Python'),
(2, 1, 'Introduction à la Science et Technologie'),
(3, 1, 'Technologies de l\'information et de la communication'),
(4, 1, 'Biologie Cellulaire'),
(5, 1, 'Introduction à la Chimie'),
(6, 1, 'Robotique et Intelligence Artificielle'),
(7, 2, 'Histoire Ancienne'),
(8, 2, 'Histoire Moderne'),
(9, 2, 'Géographie Humaine'),
(10, 2, 'Géographie Physique'),
(11, 3, 'Histoire de l\'Art'),
(12, 3, 'Musique et Composition'),
(13, 3, 'Cinéma et Réalisation'),
(14, 3, 'Littérature Comparée'),
(15, 4, 'Introduction à la Linguistique'),
(16, 4, 'Anglais Avancé'),
(17, 4, 'Espagnol Intermédiaire'),
(18, 4, 'Français pour les Professionnels'),
(19, 4, 'Langue des Signes'),
(20, 5, 'Algèbre Linéaire'),
(21, 5, 'Calcul Différentiel'),
(22, 5, 'Probabilités et Statistiques'),
(23, 5, 'Théorie des Graphes'),
(24, 5, 'Logique Mathématique'),
(25, 6, 'Anatomie et Physiologie'),
(26, 6, 'Maladies Infectieuses'),
(27, 6, 'Neuroscience'),
(28, 6, 'Psychiatrie'),
(29, 6, 'Médecine Alternative'),
(30, 1, 'test'),
(31, 1, 'teryuikl'),
(32, 1, 'dytuilm'),
(33, 1, 'uiytrdgfh');

-- --------------------------------------------------------

--
-- Structure de la table `course_user`
--

CREATE TABLE `course_user` (
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course_user`
--

INSERT INTO `course_user` (`course_id`, `user_id`) VALUES
(1, 4),
(1, 10),
(1, 15),
(2, 4),
(2, 10),
(2, 15),
(3, 4),
(3, 10),
(3, 15),
(4, 4),
(4, 10),
(4, 15),
(5, 4),
(5, 10),
(5, 15),
(6, 4),
(6, 10),
(6, 15),
(7, 10),
(7, 15),
(8, 10),
(8, 15),
(9, 10),
(9, 15),
(10, 10),
(10, 15),
(11, 4),
(11, 10),
(12, 4),
(12, 10),
(13, 4),
(13, 10),
(14, 4),
(14, 10),
(19, 10),
(20, 10),
(21, 10),
(22, 10),
(23, 10),
(24, 10),
(28, 10),
(30, 4),
(30, 10),
(31, 2),
(31, 4),
(31, 10),
(32, 2),
(32, 4),
(32, 10),
(32, 15),
(33, 2),
(33, 4),
(33, 10),
(33, 15);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240222122943', '2024-02-22 12:29:49', 192),
('DoctrineMigrations\\Version20240222132831', '2024-02-22 13:28:36', 116),
('DoctrineMigrations\\Version20240222151652', '2024-02-22 15:16:59', 38),
('DoctrineMigrations\\Version20240223123857', '2024-02-23 12:39:17', 51),
('DoctrineMigrations\\Version20240223192706', '2024-02-23 19:27:20', 87),
('DoctrineMigrations\\Version20240223192758', '2024-02-23 19:28:03', 113),
('DoctrineMigrations\\Version20240223193040', '2024-02-23 19:30:46', 36),
('DoctrineMigrations\\Version20240226170429', '2024-02-26 17:04:42', 22);

-- --------------------------------------------------------

--
-- Structure de la table `lesson`
--

CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `original_file_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lesson`
--

INSERT INTO `lesson` (`id`, `course_id`, `name`, `file`, `original_file_name`) VALUES
(1, 1, 'Introduction à Python', '66199317426619c3ce8612a663b0f0e5.png', 'Capture d’écran 2024-04-09 à 21.23.09.png'),
(2, 1, 'Variables et types de données', NULL, NULL),
(3, 1, 'Structures de contrôle', NULL, NULL),
(4, 1, 'Fonctions et modules', NULL, NULL),
(5, 1, 'Gestion des fichiers', NULL, NULL),
(6, 1, 'Programmation orientée objet', NULL, NULL),
(7, 1, 'Gestion des erreurs et exceptions', NULL, NULL),
(8, 1, 'Modules avancés', NULL, NULL),
(9, 1, 'Traitement des données avec pandas', NULL, NULL),
(10, 1, 'Visualisation des données avec Matplotlib', NULL, NULL),
(11, 2, 'Introduction à la méthode scientifique', NULL, NULL),
(12, 2, 'Histoire de la science', NULL, NULL),
(13, 2, 'Méthodes d\'observation et de mesure', NULL, NULL),
(14, 2, 'Méthodes de recherche et d\'expérimentation', NULL, NULL),
(15, 2, 'Éthique et intégrité scientifique', NULL, NULL),
(16, 2, 'Technologies émergentes', NULL, NULL),
(17, 2, 'Impacts sociaux et environnementaux des technologies', NULL, NULL),
(18, 2, 'Évolution des technologies', NULL, NULL),
(19, 2, 'Développement durable', NULL, NULL),
(20, 2, 'Innovations futures', NULL, NULL),
(21, 3, 'Introduction aux TIC', NULL, NULL),
(22, 3, 'Histoire des technologies de l\'information', NULL, NULL),
(23, 3, 'Réseaux informatiques', NULL, NULL),
(24, 3, 'Sécurité informatique', NULL, NULL),
(25, 3, 'Cloud computing', NULL, NULL),
(26, 3, 'Internet des objets (IoT)', NULL, NULL),
(27, 3, 'Big data et analytique', NULL, NULL),
(28, 3, 'Intelligence artificielle', NULL, NULL),
(29, 3, 'Impacts sociaux des TIC', NULL, NULL),
(30, 3, 'Tendances futures dans les TIC', NULL, NULL),
(31, 30, 'test1', '382015a8ff84c64d06c043f2368f2dce.pdf', 'projet.pdf'),
(32, 30, 'test2', 'ce97bbd982fb9d6895b81790024aad14.pdf', 'Symfony_PHP.pdf'),
(33, 30, 'test 3', 'b493b0c05d1d2f48075497ecad622795.pdf', 'Introduction.pdf'),
(34, 31, 'retrytuyiuoj', 'b1690b0df96a823d7f30b6185636ca0b.pdf', 'projet.pdf'),
(35, 31, 'poiuyg', 'f4f27722cd8e7619243fb61bd7e39126.pdf', 'projet.pdf'),
(36, 32, 'tuyiopù', '701c22724365ffcbdbd4d4a0f4ac86c7.pdf', 'Symfony_PHP.pdf'),
(37, 32, 'rtyuiop^ù', '7257dbd67785281a75bb9206e00f96fc.pdf', 'projet.pdf'),
(38, 32, 'rytuiooml', '82edd5cdbc00fbc3cdfe7d7cabd2ae8d.pdf', 'attestation_LYO3LSBXZJ76.pdf'),
(39, 1, 'tyiuio', '8e96ad92ed940ef07ab0949a80892779.', 'LoginAuthenticator copie.php'),
(41, 1, 'jbvbkn', '5c307861a68457ed788479b0b4d00ff5.pdf', 'DevWeb-2.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `note_student`
--

CREATE TABLE `note_student` (
  `id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `qcms_id` int(11) DEFAULT NULL,
  `score` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `note_student`
--

INSERT INTO `note_student` (`id`, `users_id`, `qcms_id`, `score`) VALUES
(91, 10, 1, 20),
(92, 10, 26, 33.3333);

-- --------------------------------------------------------

--
-- Structure de la table `post_forum`
--

CREATE TABLE `post_forum` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `content` longtext NOT NULL,
  `date` date NOT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post_forum`
--

INSERT INTO `post_forum` (`id`, `course_id`, `content`, `date`, `student_id`) VALUES
(2, 1, 'zedfgiiiii', '2024-02-23', NULL),
(3, 2, 'zesdfgvds', '2024-02-23', 10),
(4, 1, 'iouhjjjj', '2024-03-01', 10),
(5, 4, 'oiuiyhn', '2024-03-01', 10),
(6, 3, 'nkhbiuyv', '2024-04-08', 10),
(7, 1, 'hin', '2024-04-08', 10),
(8, 1, 'hbgvtf', '2024-04-08', 10);

-- --------------------------------------------------------

--
-- Structure de la table `qcm`
--

CREATE TABLE `qcm` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `qcm`
--

INSERT INTO `qcm` (`id`, `course_id`, `title`) VALUES
(1, 1, 'QCM Pythonj'),
(2, 2, 'QCM Introduction à la Science et Technologie'),
(3, 3, 'QCM Technologies de l\'information et de la communication'),
(4, 4, 'QCM Biologie Cellulaire'),
(5, 5, 'QCM Introduction à la Chimie'),
(6, 6, 'QCM Robotique et Intelligence Artificielle'),
(7, 7, 'QCM Histoire Ancienne'),
(8, 8, 'QCM Histoire Moderne'),
(9, 9, 'QCM Géographie Humaine'),
(10, 10, 'QCM Géographie Physique'),
(11, 11, 'QCM Histoire de l\'Art'),
(12, 12, 'QCM Musique et Composition'),
(13, 13, 'QCM Cinéma et Réalisation'),
(14, 14, 'QCM Littérature Comparée'),
(15, 15, 'QCM Introduction à la Linguistique'),
(16, 16, 'QCM Anglais Avancé'),
(17, 17, 'QCM Espagnol Intermédiaire'),
(18, 18, 'QCM Français pour les Professionnels'),
(19, 19, 'QCM Langue des Signes'),
(20, 20, 'QCM Algèbre Linéaire'),
(21, 21, 'QCM Calcul Différentiel'),
(22, 22, 'QCM Probabilités et Statistiques'),
(23, 23, 'QCM Théorie des Graphes'),
(24, 24, 'QCM Logique Mathématique'),
(25, 25, 'QCM Anatomie et Physiologie'),
(26, 30, 'QCM Test'),
(27, 31, 'rytuiol'),
(28, 32, 'gfhglk'),
(30, 1, 'ftgyuhij');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `qcm_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`answers`)),
  `correct_answer_index` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id`, `lesson_id`, `qcm_id`, `content`, `answers`, `correct_answer_index`) VALUES
(1, 1, 1, 'Qu\'est-ce que Python ?', '[\"Un langage de programmation\", \"Un animal\", \"Un système d\'exploitation\", \"Un navigateur web\"]', 0),
(2, 2, 1, 'Quel est le type de données utilisé pour stocker du texte en Python ?', '[\"int\", \"float\", \"str\", \"bool\"]', 2),
(3, 3, 1, 'Quelle structure de contrôle est utilisée pour exécuter une action répétée jusqu\'à ce qu\'une condition devienne fausse ?', '[\"if\", \"for\", \"while\", \"switch\"]', 2),
(4, 4, 1, 'Quelle est la principale raison d\'utiliser des fonctions en Python ?', '[\"Pour organiser le code en parties réutilisables\", \"Pour ajouter des commentaires au code\", \"Pour améliorer les performances du code\", \"Pour rendre le code plus lisible\"]', 0),
(5, 5, 1, 'Quelle fonction est utilisée pour ouvrir un fichier en mode lecture en Python ?', '[\"open()\", \"read()\", \"write()\", \"load()\"]', 0),
(6, 6, 1, 'Qu\'est-ce que l\'encapsulation en programmation orientée objet ?', '[\"La capacité de cacher les détails d\'implémentation\", \"La capacité de réutiliser le code existant\", \"La capacité de créer de nouvelles classes\", \"La capacité de créer des objets\"]', 0),
(7, 7, 1, 'Quel mot-clé est utilisé pour capturer une exception en Python ?', '[\"catch\", \"try\", \"finally\", \"throw\"]', 1),
(8, 8, 1, 'Quel module est utilisé pour manipuler les chemins de fichiers en Python ?', '[\"pathlib\", \"os\", \"sys\", \"file\"]', 0),
(9, 9, 1, 'Quelle structure de données est principalement utilisée pour manipuler les données tabulaires en Python ?', '[\"Liste\", \"Dictionnaire\", \"DataFrame\", \"Tuple\"]', 2),
(10, 10, 1, 'Quelle bibliothèque est utilisée pour la visualisation des données en Python ?', '[\"Pandas\", \"NumPy\", \"Matplotlib\", \"TensorFlow\"]', 2),
(11, 31, 26, 'ressui', '[\"rytuio\",\"etryui\",\"dfghjk\"]', 0),
(12, 32, 26, 'tryuio', '[\"dertyui\",\"uyio\",\"fghjk\"]', 1),
(13, 33, 26, 'hgiuok', '[\"yuiop\",\"guhujok\",\"ghjkl\"]', 2),
(14, 34, 27, 'ytuyioo', '[\"yuioom\",\"yuiom\",\"hkjlm\"]', 0),
(15, 35, 27, 'gjhkl', '[\"rytuio\",\"yiuo\",\"gjhkl\"]', 2),
(16, 38, 28, 'tuyiop', '[\"yiuop\",\"gjhiloml\",\"Dtudio\"]', 0),
(17, 37, 28, 'gjhklm', '[\"njklm\",\"gjhkl\",\"hjklm\"]', 1),
(18, 36, 28, 'gyiuopm', '[\"gyuio\",\"ghjklm\",\"gjhklm\"]', 2),
(19, 1, 30, 'gvhbjun', '[\"ctvybu\",\"vghbjn\",\"bhjn\",\"bhnj,\"]', 0);

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`id`, `name`, `image_url`) VALUES
(1, 'Science et Technologie', 'https://media.istockphoto.com/id/1321462048/fr/photo/concept-de-transformation-numérique-ingénierie-système-code-binaire-programmation.webp?b=1&s=170667a&w=0&k=20&c=wPkUyXV18LOP6BjTktFGxABPyF7jBYCXyFCnqMrNkgE='),
(2, 'Histoire et Géographie', 'https://media.istockphoto.com/id/1341631834/fr/photo/global-connection-lines-affaires-mondiales-échange-de-données-itinéraires-de-voyage-multi.webp?b=1&s=170667a&w=0&k=20&c=DWaTocsx5mvL8nfnPs5RYsU9sPWMijxQZzIK8SapeCA='),
(3, 'Arts et Culture', 'https://media.istockphoto.com/id/1406949600/fr/photo/deux-artistes-féminines-peignant-une-grande-fresque-murale.webp?b=1&s=170667a&w=0&k=20&c=augJuD0Pd5PilkrfbpvEVyp99_pP6_As8ZEZ5VEjaTs='),
(4, 'Langues et Linguistique', 'https://media.istockphoto.com/id/912751940/fr/photo/couple-détudiant-adulte-multi-ethniques-de-luniversité-apprendre-ensemble-dans-une-salle.webp?b=1&s=170667a&w=0&k=20&c=FIQP0j-MV1D5WdU_v6EX10jHO2XM4XKbLB3yl-s-EH4='),
(5, 'Mathématiques et Logique', 'https://media.istockphoto.com/id/695936656/fr/photo/business-woman-cerveau-hémisphère-sur-le-tableau-noir.webp?b=1&s=170667a&w=0&k=20&c=c7BgaAxGwx3j8aj9MeKAXdjnGQrwyQHGrktBnb3UBhY='),
(6, 'Santé et Médecine', 'https://media.istockphoto.com/id/1473559425/fr/photo/une-femme-médecin-rassure-une-patiente.webp?b=1&s=170667a&w=0&k=20&c=wImrg9H8CqZ0RMTomnR6sT152QKLkcUJ8WZOfz2Huww='),
(7, 'Économie et Finance', 'https://media.istockphoto.com/id/1456192902/fr/photo/photo-rapprochée-de-mains-de-femme-tapant-un-rapport-dentreprise-sur-un-clavier-dordinateur.webp?b=1&s=170667a&w=0&k=20&c=Y2F3YCaFezXHz4LFuZLLfAPTHA_9OBTyCcnnhIEMKrs='),
(8, 'Philosophie et Éthique', 'https://media.istockphoto.com/id/1030629158/fr/photo/penser-lhomme-statue.webp?b=1&s=170667a&w=0&k=20&c=RSLL3VuGBVmstm13GwPE00V713tn8H_dmeQsKdJSBRI='),
(9, 'Psychologie et Comportement', 'https://media.istockphoto.com/id/1435001168/fr/photo/une-adolescente-en-psychothérapie.webp?b=1&s=170667a&w=0&k=20&c=5J_7aMRvqOpthiH6YjFxc1V5n-K0U0bEgjiZL0f7SdY='),
(10, 'Sciences Sociales', 'https://media.istockphoto.com/id/641867044/fr/photo/nous-ferons-de-notre-mieux-pour-assurer-votre-santé.webp?b=1&s=170667a&w=0&k=20&c=_pHpECoFFgAkiQ8NnaMJb4QoJpfQzUgltS74OyLX6Qc='),
(11, 'Environnement et Écologie', 'https://media.istockphoto.com/id/1340716614/fr/photo/icône-abstraite-représentant-lappel-écologique-au-recyclage-et-à-la-réutilisation-sous-la.webp?b=1&s=170667a&w=0&k=20&c=AKqsSoOoo0URFNzX-NlAr7G2g5Xsz-bDtNrxcusYNtE='),
(12, 'Informatique et Programmation', 'https://media.istockphoto.com/id/1224500457/fr/photo/contexte-de-technologie-abstraite-de-code-de-programmation-du-développeur-de-logiciel-et-du.webp?b=1&s=170667a&w=0&k=20&c=pDPGXf27EKaLaPmULyiMf-3XPCHIQjI4hVrb_q7VgGE='),
(13, 'Droit et Législation', 'https://media.istockphoto.com/id/1491771681/fr/photo/lady-justice-in-law-office.webp?b=1&s=170667a&w=0&k=20&c=pEHt3Vxt2cILEs_xCCemq51xTk-4KZfW7abB8pfs3qI='),
(14, 'Éducation et Pédagogie', 'https://media.istockphoto.com/id/1409722748/fr/photo/élèves-levant-la-main-pendant-que-lenseignant-leur-pose-des-questions-en-classe.webp?b=1&s=170667a&w=0&k=20&c=-ghuL1KsRUAsLBwYSz-vLFxBFSB9WdcZppHw7HE5cws='),
(15, 'Sport et Activité Physique', 'https://media.istockphoto.com/id/1139036071/fr/photo/sprinter-vu-den-haut-avec-lombre-et-lespace-de-copie.webp?b=1&s=170667a&w=0&k=20&c=-sm5OkX-Apd3ciEWF9kS1rPrVNhM8PppWirNC8Uxhmc=');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `firstname`, `lastname`, `roles`, `password`) VALUES
(1, 'yass', 'ertyu', 'zretyu', 'ertyui', '[\"Admin\"]', '$2y$13$H1IuuYJydREQCcuwJzMqR.R0MHvxynRSkKDSe9vuQA0crvAERiZwC'),
(2, 'yacine', 'ertyui', 'ertyu', 'rytui', '[\"Admin\"]', '$2y$13$AuUqvZViBAgspoSKg0BAJ.nk8AE/BTY4P9mymFOD.fJDuuIwXMdXm'),
(3, 'x', 'dtryui', 'tyui', 'rtyui', '[\"Student\"]', '$2y$13$eOveSqSys10Xjw/RK2kJweNikD2SNz1oZIPt9YRaEBd57rvVoUz/m'),
(4, 'xx', 'tryughjb', 'xx', 'xx', '[\"Student\"]', '$2y$13$G10y7xOH3FvtPwfsClRUoOddNY6a7ds.uP8DrSG.4ghjtxYXpKxRO'),
(5, 'xxx', 'dfghj', 'xfdghj', 'xcvbn', '[\"Student\"]', '$2y$13$hPeF8OFXlUi1AAvcZaQcb.SxmBy9ZJ5xIEWzjHvNvTXN6d0bgtuEi'),
(6, 'xxxx', 'fghjk', 'sfdghjk', 'dfghj', '[\"Student\"]', '$2y$13$V.xHzyhEqBoFWOnMe2Z6M.t9CKviPiMnCd9aw8rflrJtP8snaUzKm'),
(7, 'y', 'ertyui', 'tyuio', 'rtyui', '[\"Student\"]', '$2y$13$UXPYpqq8Nds7nrcSha2jXer5kcCBM1QzkVlaTixPijnG7ja3w6u0.'),
(8, 'yy', 'tyiui', 'fgvhbijn', 'yy', '[\"Student\"]', '$2y$13$gqhM8GOyNEbVthLaCxOGAuBWLUc1U3Brj3XybKwj7U73fYrNsMGuq'),
(9, 'hh', 'dfhgjk', 'hh', 'hhh', '[\"Student\"]', '$2y$13$p0ktvrANdwtF5LqjSSIdtewYyw6djAicLzc4ESxmMCBnuRDglFH/i'),
(10, 'gg', 'fghjk', 'gg', 'gg', '[\"Student\"]', '$2y$13$fDlWhPeGdUk.ZYFxclDI7e3VlH9l178CJhToo2XekV3w6xOxbov6K'),
(11, 'uu', 'dftgkj', 'uu', 'uu', '[\"Student\"]', '$2y$13$z9QqYbJ.00tqZ1M7B3AJ9O4vZNqeLH6RIknd0mKqdAP78pQn0wg/O'),
(12, 'ii', 'gfguij', 'ii', 'ii', '[\"Student\"]', '$2y$13$xWhlczzujKY5q/lhCC8tc.fQOw/uqx8YpDUe8knTn7cg817i1byBm'),
(13, 'm', 'fghhjk', 'hvbjk', 'bjhk', '[\"Student\"]', '$2y$13$.Os29BWEmxIZ4nynt.lVg.7p8/Yi6P/JXx5xMUvP9hzqDAl./yIA.'),
(14, 'k', 'jhkl', 'k', 'k', '[\"Student\"]', '$2y$13$IuVELf2LSXto9dpEYR9axOF6pRDGW1QGznYQH/S5uxO999gACg2uS'),
(15, 'd', 'dtyuilk', 'fdghjk', 'ftghj', '[\"Student\"]', '$2y$13$3uXPQSC8nQ8duf4EXC2kKOR9Pt//UDrI60ln8OiXk69Z0yxLI3uAe'),
(16, 'gggggg', 'rtyuio', 'fghjkl', 'fghjk', '[\"Admin\"]', '$2y$13$oznqnWn3DcHZLOu5A5s5Me/1DTSjAa1pkDNXNXNdhHMnONrckUNnG');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_169E6FB959027487` (`theme_id`);

--
-- Index pour la table `course_user`
--
ALTER TABLE `course_user`
  ADD PRIMARY KEY (`course_id`,`user_id`),
  ADD KEY `IDX_45310B4F591CC992` (`course_id`),
  ADD KEY `IDX_45310B4FA76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F87474F3591CC992` (`course_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `note_student`
--
ALTER TABLE `note_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_36856BA967B3B43D` (`users_id`),
  ADD KEY `IDX_36856BA9D83BD9B9` (`qcms_id`);

--
-- Index pour la table `post_forum`
--
ALTER TABLE `post_forum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_12303222591CC992` (`course_id`),
  ADD KEY `IDX_12303222CB944F1A` (`student_id`);

--
-- Index pour la table `qcm`
--
ALTER TABLE `qcm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D7A1FEF4591CC992` (`course_id`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6F7494ECDF80196` (`lesson_id`),
  ADD KEY `IDX_B6F7494EFF6241A6` (`qcm_id`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `note_student`
--
ALTER TABLE `note_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pour la table `post_forum`
--
ALTER TABLE `post_forum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `qcm`
--
ALTER TABLE `qcm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `FK_169E6FB959027487` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`);

--
-- Contraintes pour la table `course_user`
--
ALTER TABLE `course_user`
  ADD CONSTRAINT `FK_45310B4F591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_45310B4FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `FK_F87474F3591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- Contraintes pour la table `note_student`
--
ALTER TABLE `note_student`
  ADD CONSTRAINT `FK_36856BA967B3B43D` FOREIGN KEY (`users_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_36856BA9D83BD9B9` FOREIGN KEY (`qcms_id`) REFERENCES `qcm` (`id`);

--
-- Contraintes pour la table `post_forum`
--
ALTER TABLE `post_forum`
  ADD CONSTRAINT `FK_12303222591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `FK_12303222CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `qcm`
--
ALTER TABLE `qcm`
  ADD CONSTRAINT `FK_D7A1FEF4591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_B6F7494ECDF80196` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`),
  ADD CONSTRAINT `FK_B6F7494EFF6241A6` FOREIGN KEY (`qcm_id`) REFERENCES `qcm` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
