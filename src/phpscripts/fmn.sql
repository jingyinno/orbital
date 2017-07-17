SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `todolist` (
  `description` text NOT NULL,
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `todolist` ('description') VALUES
('task j, task k');

