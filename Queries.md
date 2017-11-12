# table
word, mean, exam, sequence
wo, me, ex, se
## Create
```sql
-- word
CREATE TABLE `en_word` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`word` VARCHAR(250) NULL DEFAULT NULL,
	`ipa` TEXT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `key` (`word`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DYNAMIC;

-- define
CREATE TABLE `en_define` (
	`id` INT(30) NOT NULL AUTO_INCREMENT,
	`wid` INT(10) NULL DEFAULT NULL,
	`define` TEXT NULL,
	`sequence` INT(5) NULL DEFAULT NULL,
  `tid` INT(3) NULL DEFAULT NULL,
	`kid` INT(5) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DYNAMIC;

-- describe
CREATE TABLE `en_describe` (
	`id` INT(30) NOT NULL AUTO_INCREMENT,
	`sid` INT(10) NULL DEFAULT NULL,
	`describe` TEXT NULL,
	`sequence` INT(5) NOT NULL DEFAULT '0',
	`kid` INT(5) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DYNAMIC;

-- suggest table
CREATE TABLE `en_suggest` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`word` VARCHAR(250) NOT NULL,
	`type` INT(3) NULL DEFAULT '0',
	`mean` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
	`exam` TEXT NULL COLLATE 'utf8_unicode_ci',
	`lang` VARCHAR(5) NOT NULL DEFAULT 'en',
	`status` INT(5) NOT NULL DEFAULT '0',
	`uid` INT(30) NOT NULL DEFAULT '0',
	`dates` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DYNAMIC;
```

## Reset ID
```sql
-- Reset id
ALTER TABLE `db_en` DROP COLUMN `id`;
ALTER TABLE `db_en`
  ADD COLUMN `id` INT(10) NOT NULL AUTO_INCREMENT FIRST,
  ADD PRIMARY KEY (`id`);

-- Reset word_id
UPDATE `db_en` SET `word_id` = 0;
-- Create word_id
UPDATE `db_en` o
  INNER JOIN `db_en` s ON s.`source` = o.`source`
SET o.`word_id` = s.`id`

-- Clean testing
SELECT * FROM db_en WHERE source = 'love'
```

## Import
```sql
-- Import word: word from source
DELETE FROM `en_word`;
INSERT INTO `en_word` (`id`,`word`)
  SELECT `word_id`,`source` FROM `db_en` WHERE `source` !='' GROUP BY `word_id` ORDER BY `word_id` ASC;

-- Import define: Definition
DELETE FROM `en_define`;
INSERT INTO `en_define` (`id`,`define`,`wid`,`tid`,`sid`,`kid`)
  SELECT o.`id`, o.`def`, o.`word_id`, o.`state`, o.`seq`,  o.`status` FROM `db_en` o WHERE o.`def` IS NOT NULL;

-- Import describe: Usage/Example
DELETE FROM `en_describe`;
INSERT INTO `en_describe` (`id`,`describe`)
  SELECT o.`id`, o.`exam` FROM `db_en` o WHERE o.`exam` IS NOT NULL;

-- Testing by word
SELECT d.*,s.`describe` FROM `en_word` w
  INNER JOIN `en_define` d ON d.`wid` = w.`id`
  LEFT JOIN `en_describe` s ON s.`id` = d.`id`
WHERE w.`word` LIKE 'noun' ORDER BY d.`tid`, d.`sid` ASC

-- Testing by ID
SELECT d.*,s.`describe` FROM `en_define` d
  LEFT JOIN `en_describe` s ON s.`id` = d.`id`
WHERE d.`wid` LIKE '1' ORDER BY d.`tid`, d.`sid` ASC
```

## Prepare
```sql
-- Clean source
UPDATE `db_en` SET `source` = REPLACE(LTRIM(RTRIM(`source`)), '  ', ' ') WHERE `source` IS NOT NULL;
-- Clean def
UPDATE `db_en` SET `def` = NULL WHERE `def` = '';
UPDATE `db_en` SET `def` = REPLACE(LTRIM(RTRIM(`def`)), '  ', ' ') WHERE `def` IS NOT NULL;
-- Clean exam
UPDATE `db_en` SET `exam` = NULL WHERE `exam` = '';
UPDATE `db_en` SET `exam` = REPLACE(`exam`, `\\`, ``) WHERE `exam` IS NOT NULL;
UPDATE `db_en` SET `exam` = REPLACE(`exam`, "\\'", "'") WHERE `exam` IS NOT NULL;
-- UPDATE `db_en` SET `exam` = REPLACE(`exam`, ".", ".\\n") WHERE `exam` IS NOT NULL;
-- UPDATE `db_en` SET `exam` = REPLACE(`exam`, ".\\n", ".") WHERE `exam` IS NOT NULL;

-- UPDATE `db_en`
--   SET `exam` = REPLACE(
--     REPLACE(`exam`, "<b>", " [")
--   , "</b>", "] ")
-- WHERE `exam` IS NOT NULL;
--
-- UPDATE `db_en`
--   SET `exam` = REPLACE(
--     REPLACE(`exam`, "<i>", " [")
--   , "</i>", "] ")
-- WHERE `exam` IS NOT NULL;

-- UPDATE `db_en`
--   SET `exam` = REPLACE(
--     REPLACE(`exam`, "", " ")
--   , "", " ")
-- WHERE `exam` IS NOT NULL;

UPDATE `db_en` SET `exam` = REPLACE(REPLACE(`exam`, "’", "'"), "‘", "'") WHERE `exam` IS NOT NULL;
UPDATE `db_en` SET `exam` = REPLACE(LTRIM(RTRIM(`exam`)), '  ', ' ') WHERE `exam` IS NOT NULL;

-- UPDATE db_en SET source = replace(source, '\\', '');
-- UPDATE db_en set source = TRIM(source);

-- Adding word
SELECT * FROM db_en WHERE source LIKE '' ORDER BY state, seq ASC

SELECT d.* FROM `en_define` d
  INNER JOIN `en_word` w ON w.`word` = 'love'
  INNER JOIN `en_describe` s ON s.`id` = w.`id`
WHERE d.`id` = w.`id`


SELECT * FROM `db_en` WHERE `source` LIKE 'noun' ORDER BY `state`, `seq` ASC


INSERT INTO `en_define` (`wid`,`define`,`sequence`,`tid`,`kid`)
  SELECT w.`id`,o.`def`,o.`seq`,o.`state`,o.`status` FROM `db_en` o
    INNER JOIN `en_word` w WHERE w.`word` = o.`source`;



INSERT INTO `en_describe` (`sid`,`describe`)
  SELECT w.`id`, o.`exam` FROM `db_en` o
    INNER JOIN `en_define` w ON w.`define` LIKE o.`def`
  WHERE o.`exam` IS NOT NULL
  LIMIT 100,100;

INSERT INTO `en_describe` (`sid`,`describe`,`sequence`)
  SELECT `id`,`describe`,`sequence` FROM `en_define` WHERE `describe` IS NOT NULL;

-- Testing with basic
SELECT d.* FROM en_define d
  INNER JOIN en_word w ON w.word = 'love'
WHERE d.wid= w.id
-- Testing with describe
SELECT d.* FROM en_define d
  INNER JOIN en_word w ON w.word = 'love'
  INNER JOIN en_describe s ON s.sid = w.id
WHERE d.wid= w.id
Orders LIMIT 30;

INSERT INTO `en_describe` (`sid`,`describe`,`sequence`) SELECT `id`,`describe`,`sequence` FROM `en_define` WHERE `describe` IS NOT NULL;
```

## exam to be replace
```sql
[pos:*]
[with:*]
[list:*]
[list:-er/-est]
[list:-ier/-iest]
[list:-eries]
[abbr:*]
[also:*]
[brit:*]
[US:*]
[asin:British]
[asin:American]
[asin:Mathematics]
[asin:Grammar]
UPDATE `db_en`
  SET `exam` = REPLACE(REPLACE(`exam`, " ]", "]") , "[ ", "[")
WHERE `exam` IS NOT NULL;
UPDATE `db_en` SET `exam` = REPLACE(`exam`, "[as adj. ]", "[pos:A]") WHERE `exam` IS NOT NULL;
UPDATE `db_en` SET `exam` = REPLACE(LTRIM(RTRIM(`exam`)), '  ', ' ') WHERE `exam` IS NOT NULL;
SELECT * FROM `db_en` WHERE `exam` LIKE '%[%' ORDER BY `source`, `state`, `seq` ASC
SELECT * FROM `db_en` WHERE `source` LIKE 'noun' ORDER BY `source`, `state`, `seq` ASC


-- UPDATE `db_en` SET `exam` =
--   REPLACE(
--     REPLACE(
--       REPLACE(
--         REPLACE(`exam`, " </b>", "</b>"),
--         "<b> ", "<b>"),
--       "</b>", "</b> "),
--     "<b>", " <b>")
-- WHERE `exam` IS NOT NULL;
UPDATE `db_en` SET `exam` =
  REPLACE(
    REPLACE(`exam`, "</b>", "-)"),
    "<b>", "(-")
WHERE `exam` IS NOT NULL;
UPDATE `db_en` SET `exam` =
  REPLACE(
    REPLACE(`exam`, "</i>", "!)"),
    "<i>", "(!")
WHERE `exam` IS NOT NULL;
```
(abbr <b>TB </b>)
-> [abbr:TB,AC]
(also <b>TB </b>)
-> [also:TB,AC]

'N'=>'Noun',
'p'=>'Plural',
'h'=>'Noun Phrase',
'V'=>'Verb (usu participle)',
't'=>'Verb (transitive)',
'i'=>'Verb (intransitive)',
'A'=>'Adjective',
'v'=>'Adverb',
'C'=>'Conjunction',
'P'=>'Preposition',
'!'=>'Interjection',
'r'=>'Pronoun',
'D'=>'Definite Article',
'I'=>'Indefinite Article',
'o'=>'Nominative'

a fortnightly clinic/ magazine. [as adj ]
-> a fortnightly clinic/ magazine. [pos:A]

He is tired of {patience} and {gentleness} and {docility}.
-> He is tired of [list:patience,gentleness,docility].

(NAFTA)
-> [abbr:NAFTA]
(Brit <b>millimetre</b>) (abbr <b>mm</b>)
-> [brit:millimetre] [abbr:mm]

(also <b>kerosine</b>) (esp US) 	= PARAFFIN: <i> a kerosene lamp.</i>
-> [also:kerosine] [US:PARAFFIN] a kerosene lamp.

{Too bad,} she replied laconically.
-> Too bad, she replied laconically.

My wife is ailing. (figurative) the ailing economy.
-> My wife is ailing.
-> (figurative) the ailing economy.

she was charged as an <b>accessory to</b> murder.
->she was charged as an (accessory to) murder.

swear/make/take/sign an affidavit.
-> [swear,make,take,sign] an affidavit.

a sexually transmitted disease (eg AIDS).
She lives locally (ie near).
My secretary will see you out (ie of the building).

## Change
```sql
-- Define table
ALTER TABLE en_define
	CHANGE COLUMN `state` `tid` INT(3),
	CHANGE COLUMN `def` `define` TEXT,
	CHANGE COLUMN `exam` `describe` TEXT,
	CHANGE COLUMN `seq` `sequence` INT(5),
	CHANGE COLUMN `status` `kid` INT(5),
	CHANGE COLUMN `word_id` `wid` INT(10) AFTER `id`,
	CHANGE COLUMN `source` `source` VARCHAR(250) AFTER `uid`,
	DROP COLUMN `pron`,
	DROP COLUMN `type_id`,
	DROP COLUMN `definition_id`,
	DROP COLUMN `mdate`;

-- Rename table
ALTER TABLE `db_ar` RENAME `ar_word`;
ALTER TABLE `db_da` RENAME `da_word`;
ALTER TABLE `db_de` RENAME `de_word`;
ALTER TABLE `db_el` RENAME `el_word`;
ALTER TABLE `db_en` RENAME `en_word`;
ALTER TABLE `db_es` RENAME `es_word`;
ALTER TABLE `db_fi` RENAME `fi_word`;
ALTER TABLE `db_fr` RENAME `fr_word`;
ALTER TABLE `db_hi` RENAME `hi_word`;
ALTER TABLE `db_iw` RENAME `iw_word`;
ALTER TABLE `db_ja` RENAME `ja_word`;
ALTER TABLE `db_ko` RENAME `ko_word`;
ALTER TABLE `db_ms` RENAME `ms_word`;
ALTER TABLE `db_nl` RENAME `nl_word`;
ALTER TABLE `db_no` RENAME `no_word`;
ALTER TABLE `db_pl` RENAME `pl_word`;
ALTER TABLE `db_pt` RENAME `pt_word`;
ALTER TABLE `db_ro` RENAME `ro_word`;
ALTER TABLE `db_ru` RENAME `ru_word`;
ALTER TABLE `db_sv` RENAME `sv_word`;
ALTER TABLE `db_th` RENAME `th_word`;
ALTER TABLE `db_tl` RENAME `tl_word`;
ALTER TABLE `db_vi` RENAME `vi_word`;
ALTER TABLE `db_zh` RENAME `zh_word`;
-- Rename wordweb
ALTER TABLE `en_antonym` RENAME `ww_antonym`;
ALTER TABLE `en_derive` RENAME `ww_derive`;
ALTER TABLE `en_derive_see` RENAME `ww_derive_see`;
ALTER TABLE `en_derive_type` RENAME `ww_derive_type`;
ALTER TABLE `en_mapping` RENAME `ww_mapping`;
ALTER TABLE `en_sense` RENAME `ww_sense`;
ALTER TABLE `en_word` RENAME `ww_word`;
ALTER TABLE `en_word_type` RENAME `ww_word_type`;

-- Other table(NOT en)
ALTER TABLE `*_word`
	CHANGE COLUMN `source` `word` VARCHAR(250),
	CHANGE COLUMN `state` `define` TEXT,
	CHANGE COLUMN `def` `describe` TEXT AFTER `define`,
	CHANGE COLUMN `status` `status` INT(5),
	DROP COLUMN `uid`,
	DROP COLUMN `mdate`;

```

## Import Old version
```sql
-- Import word
INSERT INTO mo_en_word (word) SELECT source FROM mo_en_define GROUP BY source ORDER BY source ASC;
INSERT INTO mo_en_word (word) SELECT source FROM mo_en_define GROUP BY source ORDER BY source DESC;
-- Import describe
UPDATE `mo_en_define` SET `describe` = NULL WHERE `describe` = '';
INSERT INTO `mo_en_describe` (`sid`,`describe`,`sequence`) SELECT `id`,`describe`,`sequence` FROM `mo_en_define` WHERE `describe` IS NOT NULL;

-- Import IDs
UPDATE mo_en_define d
  INNER JOIN mo_en_word w ON d.source = w.word
SET d.wid = w.id
WHERE d.source = w.word;

-- Check duplicate
UPDATE mo_en_define d
  INNER JOIN mo_en_word w ON d.source = w.source
SET d.wid = w.id
WHERE (d.source = w.source) AND (d.wid != w.id);

-- Search word
SELECT d.* FROM mo_en_define d
  INNER JOIN mo_en_word w ON w.word = 'love'
WHERE d.wid= w.id;

-- Search ...
SELECT d.* FROM mo_en_define d
  INNER JOIN mo_en_word w ON w.word = 'love'
  INNER JOIN mo_en_describe s ON s.sid = w.id
WHERE d.wid= w.id;

SELECT w.*, d.*
  FROM mo_en w  
  LEFT JOIN mo_en_define d ON d.wid = w.id
WHERE w.word = 'love';

SELECT w.*, d.*
  FROM mo_en w  
  LEFT JOIN mo_en_define d ON d.wid = w.id
  LEFT JOIN mo_en_describe s ON s.sid = d.id
WHERE w.word = 'love';

SELECT  bird_name, member_id
  FROM birds  
  LEFT JOIN bird_likes ON birds.bird_id = bird_likes.bird_id
WHERE member_id = 2;
```
mo_define, mo_describe
en_define, en_describe
en_word
## Utilities
```sql
UPDATE db_en SET source = replace(source, '\\', '');
UPDATE db_en set source = TRIM(source);
```
