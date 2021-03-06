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
 * People : les requêtes ajax
 *
 * @author Bertrand Boutillier <b.boutillier@gmail.com>
 * @contrib fr33z00 <https://github.com/fr33z00>
 */

header('Content-Type: application/json');

$debug='';
$m=$match['params']['m'];
$acceptedModes=array(
    'getRelationsPraticiens', // autocomplete : obtenir le json des praticiens
    'addRelationPatientPraticien', //Ajouter une reelation patient <-> praticien
    'removeRelationPatient', // Retirer une reelation patient
    'getRelationsPatientPraticiensTab', // Obtenir le tableau de relations patient <-> praticiens
    'getRelationsPatients', //Autocomplete : obtenir le json des patients
    'addRelationPatientPatient', //Ajouter une reelation patient <-> patient
    'getRelationsPatientPatientsTab', // Obtenir le tableau de relations patient <-> patients
    'setExternAsPatient', //relier un externe à un patient
    'setExternAsNewPatient', //transformer un externe en patient
    'peopleDestroy', //détruire un dossier
);

if (!in_array($m, $acceptedModes)) {
    die;
}

//inclusion
include('inc-ajax-'.$m.'.php');
