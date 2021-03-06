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
* Gestion des individus : droits
*
* @author Bertrand Boutillier <b.boutillier@gmail.com>
*/

class msPeopleDroits extends msPeople
{

/**
 * Data d'un ligne de la tbale people
 * @var array
 */
  private $_basicUserData;

  function __construct($toID) {
    if (!isset($toID) or !is_numeric($toID)) {
        throw new Exception('ToID is not set');
    }
    $this->setToID($toID);
    if($basicUserData = msSQL::sqlUnique("SELECT type, `rank`, pass FROM people WHERE id='".$toID."' limit 1")) {
      $this->_basicUserData = $basicUserData;
    } else {
      throw new Exception("This people don't exist");
    }
  }

/**
 * Vérifier si le people est admin
 * @return bool true/false
 */
  public function checkIsAdmin() {
    if(isset($this->_basicUserData['rank']) and $this->_basicUserData['rank'] == 'admin') {
      return true;
    } else {
      return false;
    }
  }

/**
 * Vérifier si le people est utilisateur
 * @return bool true/false
 */
  public function checkIsUser() {
    if(empty($this->_basicUserData['pass'])) {
      return false;
    } else {
      return true;
    }
  }

/**
 * Vérifier si le people est de type destroyed
 * @return bool true/false
 */
  public function checkIsDestroyed() {
    if($this->_basicUserData['type'] == 'destroyed') {
      return true;
    } else {
      return false;
    }
  }

}
