CREATE TABLE `auth` (
  `id` int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
);

INSERT INTO `auth` (`id`, `email`, `password`) VALUES
(12, 'admin@example.com', 'yourencrypted-md5password');


CREATE TABLE `likes` (
  `id` int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(255) NOT NULL,
  `music_id` int(255) NOT NULL);

CREATE TABLE `messages` (
  `id` int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `origin_id` int(255) NOT NULL,
  `target_id` int(255) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `content` varchar(500) NOT NULL,
  `was_read` int(1) NOT NULL DEFAULT '0',
  `replies_to` int(255) DEFAULT NULL
);

CREATE TABLE `music` (
  `id` int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `genre` int(10) NOT NULL,
  `explicit` int(1) NOT NULL DEFAULT '0',
  `likes` int(255) NOT NULL DEFAULT '0',
  `country` varchar(2) NOT NULL,
  `plays` int(255) NOT NULL DEFAULT '0'
);

CREATE TABLE `posts` (
  `id` int(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `content` varchar(500) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `day` datetime NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `country` varchar(2) NOT NULL DEFAULT 'UY'
);

CREATE TABLE `sponsors` (
  `id` int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `clicks` int(255) NOT NULL DEFAULT '0'
);
CREATE TABLE `users` (
  `id` int(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dir` varchar(50) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `rand_key` varchar(255) DEFAULT NULL,
  `genre` char(255) DEFAULT NULL,
  `banned` int(1) NOT NULL DEFAULT '0',
  `plan` int(11) NOT NULL DEFAULT '0',
  `payment_date` date DEFAULT NULL,
  `music_count` int(25) NOT NULL DEFAULT '0',
  `description` varchar(500) NOT NULL,
  `country` varchar(2) NOT NULL);


