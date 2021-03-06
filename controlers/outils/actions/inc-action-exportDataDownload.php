<?php
/*
 * This file is part of MedShakeEHR.
 *
 * Copyright (c) 2019
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
 * Outils : export data -> retourner le csv
 *
 * @author Bertrand Boutillier <b.boutillier@gmail.com>
 */

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

//admin uniquement
if ($p['config']['droitExportPeutExporterPropresData'] != 'true') {
  $template="forbidden";
} else {

  $formExport = new msExportData;
  if(!empty($_POST)) {

    $data=new msData;
    $p['page']['dataTypeinfos']=$data->getDataType($_POST['dataTypeID'], ['id','groupe', 'formValues', 'formType']);

    if($p['page']['dataTypeinfos']['groupe']!='typecs' or $p['page']['dataTypeinfos']['formType']!='select') die("Ce formulaire n'autorise pas l'export de données");

    $sortTab=array('id','patient_id', 'praticien_id', 'date_saisie', 'date_effective', 'date_modification');

    foreach($_POST as $k=>$v) {
      $kParts=explode('_', $k);
      $kType=$kParts[0];
      unset($kParts[0]);
      $kKey=implode('_', $kParts);

      if($k=='dataTypeID' and is_numeric($v)) {
        $formExport->setDataTypeIDs($v);
      }
      elseif($k=='formID' and is_numeric($v)) {
        $formExport->setFormID($v);
      }
      elseif($kType=='patient') {
        $formExport->addToDataAdminPatientList($kKey);
        $sortTab[]='patient_'.$kKey;
      }
      elseif($kType=='praticien') {
        $formExport->addToDataAdminPratList($kKey);
        $sortTab[]='praticien_'.$kKey;
      }
      elseif($kType=='dataField') {
        $formExport->addToFormFieldList($kKey);
        $sortTab[]='data_'.$kKey;
      }
      elseif($kType=='pratliste' and is_numeric($kKey)) {
        if ($p['config']['droitExportPeutExporterAutresData'] == 'true' or $p['user']['id'] == $kKey) {
          $formExport->addToPratList($kKey);
        }
      }
      elseif($k=='date_start') {
        $formExport->setDateStart($v);
      }
      elseif($k=='date_end') {
        $formExport->setDateEnd($v);
      }
      elseif($k=='date_type') {
        $formExport->setDateType($v);
      }
      elseif($k=='option_select_type') {
        $formExport->setOptionSelect($v);
      }
    }
    $formExport->setSortTab($sortTab);
  }

  $data=$formExport->getTabData();
  $corres=$formExport->getTabCorrespondances();

  if($_POST['option_file_format']=='xlsx') {
    $writer = WriterFactory::create(Type::XLSX);
    $writer->openToBrowser('export.xlsx');
  } else {
    $writer = WriterFactory::create(Type::ODS);
    $writer->openToBrowser('export.ods');
  }
  $datasheet = $writer->getCurrentSheet();
  $datasheet->setName('Data');
  if(!empty($data)) {
    $writer->addRow(array_keys($data[key($data)]));
    $writer->addRows($data);
  } else {
    $writer->addRow(['Aucune donnée trouvée']);
  }

  $corressheet = $writer->addNewSheetAndMakeItCurrent();
  $corressheet->setName('Corespondances');
  if(!empty($corres)) {
    foreach($corres as $type=>$dat){
      $writer->addRow([' ']);
      $writer->addRow([$type]);
      foreach($dat as $k=>$v){
        $writer->addRow([$k, $v]);
      }
    }
  }

  $writer->setCurrentSheet($datasheet);
  $writer->close();

;}
die;
