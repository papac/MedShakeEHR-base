<?php
/*
 * This file is part of MedShakeEHR.
 *
 * Copyright (c) 2017
 * Bertrand Boutillier <b.boutillier@gmail.com>
 * http://www.medshake.net
 *
 * MedShakeEHR is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * MedShakeEHR is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MedShakeEHR.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Config : les requêtes ajax
 *
 * @author Bertrand Boutillier <b.boutillier@gmail.com>
 */

header('Content-Type: application/json');

$m=$match['params']['m'];

$acceptedModes=array(
    'configDataCatCreate', // Création d'une cat pour données
    'configDataTypeCreate', // Création d'un type de données
    'configDelByPrimaryKey', // Effacer dans une table par l'intermédiaire de la primary key
    'configExtractByPrimaryKey', // Effacer dans une table par l'intermédiaire de la primary key
    'configFormsCatCreate', // Création d'une cat pour les forms
    'configFormCreate', // Création d'un form
    'configPrescriptionCreate', //Création d'une prescription type
    'configPrescriptionsCatCreate', //Création d'une cat de prescription type
    'configActesCreate', //Création d'un acte
    'configActesCatCreate', //Création d'une cat d'actes
    'configTagDicomCreate' //Associer tag dicom et typeID
);

if (!in_array($m, $acceptedModes)) {
    die;
}

// Création d'une cat pour form
if ($m=='configFormsCatCreate') {
    include('inc-ajax-configFormsCatCreate.php');
}

// Création d'un form
elseif ($m=='configFormCreate') {
    include('inc-ajax-configFormCreate.php');
}

// Création d'une cat pour données
elseif ($m=='configDataCatCreate') {
    include('inc-ajax-configDataCatCreate.php');
}

// Création d'un type pour données
elseif ($m=='configDataTypeCreate') {
    include('inc-ajax-configDataTypeCreate.php');
}

// Delete row in table database by primary key
elseif ($m=='configDelByPrimaryKey') {
    include('inc-ajax-configDelByPrimaryKey.php');
}

// Extract data by primary key
elseif ($m=='configExtractByPrimaryKey') {
    include('inc-ajax-configExtractByPrimaryKey.php');
}

// Création d'une prescription type
elseif ($m=='configPrescriptionCreate') {
    include('inc-ajax-configPrescriptionCreate.php');
}

// Création d'une cat pour données
elseif ($m=='configPrescriptionsCatCreate') {
    include('inc-ajax-configPrescriptionsCatCreate.php');
}

// Création d'un acte
elseif ($m=='configActesCreate') {
    include('inc-ajax-configActesCreate.php');
}

// Création d'une cat pour données
elseif ($m=='configActesCatCreate') {
    include('inc-ajax-configActesCatCreate.php');
}

// Création d'une cat pour données
elseif ($m=='configTagDicomCreate') {
    include('inc-ajax-configTagDicomCreate.php');
}

die();
