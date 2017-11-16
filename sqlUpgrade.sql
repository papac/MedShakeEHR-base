-- Modifications de structure de la bdd d'une version à la suivante

CREATE TABLE agenda_changelog (
  `id` int(8) UNSIGNED NOT NULL,
  `eventID` int(12) UNSIGNED NOT NULL,
  `userID` smallint(5) UNSIGNED NOT NULL,
  `fromID` smallint(5) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `operation` enum('edit','move','delete','missing') NOT NULL,
  `olddata` mediumblob DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE agenda_changelog
  ADD PRIMARY KEY (`id`),
  ADD KEY `eventID` (`eventID`);
ALTER TABLE agenda_changelog
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

update forms set internalName='baseNewPatient' where id='1';
update forms set internalName='baseListingPatients' where id='2';
update forms set internalName='baseLogin' where id='3';
update forms set internalName='baseATCD' where id='4';
update forms set internalName='baseSynthese' where id='5';
update forms set internalName='baseNewPro' where id='7';
update forms set internalName='baseListingPro' where id='8';
update forms set internalName='baseConsult' where id='10';
update forms set internalName='baseSendMail' where id='11';
update forms set internalName='baseSendMailApicrypt' where id='14';
update forms set internalName='baseImportDocExterne' where id='15';
update forms set internalName='baseOrdonnance' where id='16';
update forms set internalName='baseReglement' where id='17';
update forms set internalName='baseReglementSimple' where id='18';
update forms set internalName='baseReglementSearch' where id='19';
update forms set internalName='baseImportExternal' where id='22';
update forms set internalName='basePasswordChange' where id='25';
update forms set internalName='baseFax' where id='29';
update forms set internalName='baseAgendaPriseRDV' where id='30';

ALTER TABLE forms ADD internalName varchar(60) after id;

ALTER TABLE agenda ADD fromID mediumint(6) UNSIGNED DEFAULT NULL after patientid;
ALTER TABLE agenda DROP PRIMARY KEY;
ALTER TABLE agenda ADD PRIMARY KEY (`id`), ADD KEY `userid` (`userid`); ;
ALTER TABLE agenda MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 1.3.0 to 1.4.0

ALTER TABLE data_types MODIFY COLUMN placeholder VARCHAR(255) DEFAULT null;
ALTER TABLE data_types MODIFY COLUMN label VARCHAR(60) DEFAULT null;
ALTER TABLE data_types MODIFY COLUMN description VARCHAR(255) DEFAULT null;
ALTER TABLE data_types MODIFY COLUMN validationRules VARCHAR(255) DEFAULT null;
ALTER TABLE data_types MODIFY COLUMN validationErrorMsg VARCHAR(255) DEFAULT null;
ALTER TABLE `data_types` CHANGE `formType` `formType` ENUM('','date','email','lcc','number','select','submit','tel','text','textarea') NOT NULL DEFAULT '';
ALTER TABLE `data_types` CHANGE `formValues` `formValues` TEXT NULL DEFAULT NULL;

-- 1.1.0 to 1.2.0

CREATE TABLE `agenda` (
  `id` int(12) UNSIGNED NOT NULL,
  `userid` smallint(5) UNSIGNED NOT NULL DEFAULT '3',
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `dateAdd` datetime DEFAULT NULL,
  `patientid` mediumint(6) UNSIGNED DEFAULT NULL,
  `statut` enum('actif','deleted') DEFAULT 'actif',
  `absente` enum('non','oui') DEFAULT 'non',
  `motif` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`,`userid`) USING BTREE,
  ADD KEY `patientid` (`patientid`);

-- 1.0.1 to 1.1.0
ALTER TABLE inbox ADD COLUMN mailHeaderInfos blob AFTER txtFileName;
