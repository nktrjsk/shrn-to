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
    `status` text NOT NULL,
    `username` text NOT NULL,
    `password` varchar(129) NOT NULL,
    `bio` varchar(500) NOT NULL
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

-- Data

INSERT INTO `kategorie` VALUES
(1, 'Jednoduchý', 'jednoduchy', NULL),
(2, 'Ale jednoduchý', 'ale_jednoduchy', 1);

INSERT INTO `uzivatele` VALUES
(1, 'nktrjsk', "owner", 'nktrjsk', '0b72bc75726742d347d9e8e182234c4cb42e630b6c6b3a264a3491d51f921f55$622ed8d05081ebcbd535c0dde0fa2dac414cbad05d76f18f13b2e06b377a75d1', 'Test'),
(2, 'r0', "user", 'default', 'c8c191c7efc3aa3696059ad5fe7cd771d45e04db9dc17d646ef92a24a1d1b0a4$10a58ff08170ff166603f7d30aa8ab6a68abe9493b9b69261bffc5988b05685c', 'Test1');

INSERT INTO `clanky` VALUES
(1, NULL, 1648296295, NULL, 1, 'Vítejte na Shrň.to', 'Zdravím vás na Shrň.to. Stránce, která má za účel shrnout jakýkoliv delší obsah do krátkého textu a bodů, které jsou lehce stravitelné, a lze se k nim vracet, a v krátkém čase mu porozumět.', ' '),
(2, 2, 1648296295, NULL, 2, 'Test nadpis', 'Test text', 'http://test.cz')