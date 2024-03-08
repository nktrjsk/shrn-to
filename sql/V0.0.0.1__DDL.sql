CREATE TABLE IF NOT EXISTS `clanky`(
    `id` bigint UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `category_id` bigint UNSIGNED NULL,
    `created` int UNSIGNED NOT NULL,
    `updated` int UNSIGNED NULL,
    `autor` bigint UNSIGNED NOT NULL,
    `nadpis` text NOT NULL,
    `text` text NOT NULL,
    `sources` text NOT NULL
);
CREATE TABLE IF NOT EXISTS `kategorie`(
    `id` bigint UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    `path_name` varchar(128) NOT NULL,
    `parent_id` bigint UNSIGNED NULL
);
CREATE TABLE IF NOT EXISTS `uzivatele`(
    `id` bigint UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` text NOT NULL,
    `status` text NOT NULL DEFAULT "user",
    `username` text NOT NULL,
    `password` varchar(129) NOT NULL,
    `bio` varchar(500) NOT NULL DEFAULT ""
);

ALTER TABLE `clanky`
ADD FOREIGN KEY (`category_id`) REFERENCES `kategorie`(`id`);
ALTER TABLE `clanky`
ADD FOREIGN KEY (`autor`) REFERENCES `uzivatele`(`id`);
ALTER TABLE `clanky`
ADD UNIQUE (`nadpis`);

ALTER TABLE `kategorie`
ADD FOREIGN KEY (`parent_id`) REFERENCES `kategorie`(`id`);
ALTER TABLE `kategorie`
ADD UNIQUE (`path_name`);

ALTER TABLE `uzivatele`
ADD UNIQUE (`user_id`);