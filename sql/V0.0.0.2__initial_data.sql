INSERT INTO `kategorie` (name,path_name,parent_id) VALUES
('Jednoduchý', 'jednoduchy', NULL),
('Ale jednoduchý', 'ale_jednoduchy', 1);

INSERT INTO `uzivatele` (user_id,status,username,password,bio) VALUES
('nktrjsk', 'away', 'nktrjsk', '0b72bc75726742d347d9e8e182234c4cb42e630b6c6b3a264a3491d51f921f55$622ed8d05081ebcbd535c0dde0fa2dac414cbad05d76f18f13b2e06b377a75d1', 'can\'t write SQL');

INSERT INTO `clanky` (category_id,created,updated,autor,nadpis,text,sources) VALUES
(NULL, 0, 0, (SELECT id FROM uzivatele WHERE user_id='nktrjsk'), 'sadkjewqjtklewqjtklewq', '', ''),
(NULL, 0, 0, (SELECT id FROM uzivatele WHERE user_id='nktrjsk'), 'Nadpis1', 'sdjklewtwet', 'http://test.cz')