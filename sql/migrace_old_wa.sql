-- odstranit unikatnost vydavatelu

ALTER TABLE `publishers` DROP INDEX `name` ,
ADD INDEX `name` ( `name` ) ;
-- upravy tabulky
ALTER TABLE `zdroje` CHANGE `smlouvy_id` `smlouvy_id` INT( 11 ) NULL DEFAULT NULL ;
update zdroje set smlouvy_id = NULL where smlouvy_id = 0;
-- 2568 row(s) affected.
-- povolit NULL hodnoty
ALTER TABLE `vydavatele` CHANGE `adresa` `adresa` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_czech_ci NULL DEFAULT NULL ,
CHANGE `kont_osoba` `kont_osoba` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_czech_ci NULL DEFAULT NULL ,
CHANGE `vysledek_jednani` `vysledek_jednani` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_czech_ci NULL DEFAULT NULL ;
ALTER TABLE `vydavatele` MODIFY COLUMN `email` VARCHAR(100)  CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL;
ALTER TABLE `contacts` MODIFY COLUMN `phone` VARCHAR (20)  CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL;
-- oprava prazdnych sloupcu na NULL
UPDATE zdroje SET issn = NULL WHERE issn = '';
-- 3082 row(s) affected. 
UPDATE zdroje SET poznamka = NULL WHERE poznamka = '';
-- 494
UPDATE zdroje SET odmitnuti = NULL WHERE odmitnuti = '';
-- 2051
update vydavatele set fax = NULL where fax = '';
-- 2947
update vydavatele set tel = NULL where tel = '';
-- 2556
update vydavatele set email = NULL where email = '';
-- 276
update vydavatele set vysledek_jednani = NULL where vysledek_jednani = '';
-- 2243
update vydavatele set adresa = NULL where adresa = '';
-- 2224
update vydavatele set kont_osoba = NULL where kont_osoba= '';
-- 1811
update vydavatele set prvni_kontakt = NULL where prvni_kontakt = 0000-00-00;
-- 783
update vydavatele set druhy_kontakt = NULL where druhy_kontakt = 0000-00-00;
-- 957

-- vybrat a vlozit vydavatele 

INSERT INTO publishers (id, name) SELECT id, jmeno_vyd AS name FROM `vydavatele`;
--3111 row(s) inserted. 

-- vlozeni smluv
ALTER TABLE `contracts` DROP INDEX `contract_title_unique` ;
INSERT INTO contracts (id, contract_no, year, date_signed, addendum) SELECT id, cislo_smlouvy as contract_no, rok as year, datum_podpisu as date_signed, doplnek as addendum FROM `smlouvy`;
-- 1045 row(s) inserted. 
-- problem s duplikaty ID
ALTER TABLE `waTest_new`.`resources` DROP INDEX `title` ,
ADD INDEX `title` ( `title` ) ;
update zdroje set id = (id + 350) where id > 3871;
-- vlozeni zdroju
INSERT INTO resources (id, title, url, ISSN, comments, publisher_id, contract_id) SELECT id, nazev, url, issn, poznamka, vydavatele_id, smlouvy_id FROM zdroje;

-- defaultni kurator
update resources set curator_id = 49 WHERE curator_id IS NULL;

-- select pro kontakty
INSERT INTO contacts (id, publisher_id, email, address, phone, name) SELECT id, id, email, adresa, tel, kont_osoba FROM `vydavatele` WHERE (email IS NOT NULL OR kont_osoba IS NOT NULL) AND id < 3500;

-- prirazeni kontaktu zdroji
update resources r, contacts c set r.contact_id = c.id where r.publisher_id = c.publisher_id AND c.publisher_id < 3500;

-- korespondence - prvni osloveni

insert into correspondence (resource_id, date, correspondence_type_id) SELECT z.id, prvni_kontakt, 1 FROM `vydavatele` v, zdroje z WHERE prvni_kontakt IS NOT NULL and z.vydavatele_id = v.id;

-- korespondence - druhe osloveni

insert into correspondence (resource_id, date, correspondence_type_id) SELECT z.id, druhy_kontakt, 2 FROM `vydavatele` v, zdroje z WHERE druhy_kontakt IS NOT NULL and z.vydavatele_id = v.id;

-- seminka

INSERT INTO seeds (url, resource_id, seed_status_id, redirect) SELECT r.url, r.id, 1, 0 FROM resources r WHERE r.publisher_id < 3500 AND r.url != '';

-- katalogizace

UPDATE resources SET catalogued = NOW() WHERE comments LIKE '%zkatalogizováno%' OR comments LIKE '%zkatalogizovano%';

-- HODNOCENI

-- NE (1)
UPDATE resources r,
zdroje z SET r.rating_result =1 WHERE z.id = r.id AND z.odmitnuti like 'wa' AND (
z.`poznamka` NOT LIKE '%prehodnotit%' AND z.poznamka NOT LIKE '%přehodnotit%' OR z.poznamka IS NULL
);

-- MOZNA (3)
UPDATE resources r,
zdroje z SET r.rating_result = 3 WHERE z.id = r.id AND z.odmitnuti like 'wa' AND (
z.`poznamka` LIKE '%prehodnotit%' OR z.poznamka LIKE '%přehodnotit%'
);

-- ANO (2)
UPDATE resources r,
zdroje z SET r.rating_result = 2 WHERE z.id = r.id AND (z.odmitnuti NOT LIKE 'wa' OR z.odmitnuti IS NULL);

--STAVY

-- osloven - 8
-- nema smlouvu, byl alespon jednou osloven a nebyl odmitnut
UPDATE `resources` r, zdroje z, vydavatele v
SET r.resource_status_id = 8
WHERE z.id = r.id
AND z.odmitnuti IS NULL
AND v.prvni_kontakt IS NOT NULL
AND v.id = r.publisher_id
AND r.contract_id IS NULL;

-- schvalen wa
UPDATE `resources` r, zdroje z, vydavatele v
SET r.resource_status_id = 2
WHERE z.id = r.id
AND z.odmitnuti IS NULL
AND v.prvni_kontakt IS NULL
AND v.id = r.publisher_id
AND r.contract_id IS NULL;

-- schvaleno vydavatelem - 5 + rating_result = ANO, pokud ma zdroj smlouvu, nastavi stav na schvaleno vydavatelem
Update resources set resource_status_id = 5 where contract_id is not null AND publisher_id < 3500;

-- k prehodnoceni - 3 + rating_result = MOZNA - (v poznamce je prehodnotit nebo přehodnotit)
update resources r, zdroje z set r.resource_status_id = 3 WHERE 
z.id = r.id AND z.odmitnuti = 'wa' AND (
z.`poznamka` LIKE '%prehodnotit%' OR z.poznamka LIKE '%přehodnotit%'
);

-- bez odezvy (7)
update resources r, zdroje z set r.resource_status_id = 7 WHERE r.id = z.id AND z.odmitnuti = 'vy' AND z.poznamka like '%bez odezvy%';

-- odmitnuti zdroje wa - 4, (odmitnuti = wa)
update resources r, zdroje z set r.resource_status_id = 4 WHERE z.id = r.id AND z.odmitnuti = 'wa' AND (
z.poznamka IS NULL OR (z.`poznamka` NOT LIKE '%prehodnotit%' AND z.poznamka NOT LIKE '%přehodnotit%')
);

-- odmitnuti zdroje vydavatelem - 6 (odmitnuti = vy)
update resources r, zdroje z set r.resource_status_id = 6 WHERE r.id = z.id AND z.odmitnuti = 'vy' AND (z.poznamka IS NULL OR z.poznamka not like '%bez odezvy%');
