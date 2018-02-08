<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class SoundLevel extends eqLogic {
    /*     * *************************Attributs****************************** */



    /*     * ***********************Methode static*************************** */

    /*
     * Fonction exécutée automatiquement toutes les minutes par Jeedom
     */
    public static function cron() {
        foreach (eqLogic::byType('SoundLevel', true) as $eqLogic) {
            $eqLogic->updateInfo();
        }
    }

    /*     * *********************Méthodes d'instance************************* */

    public function preInsert() {

    }

    public function postInsert() {

    }

    public function preSave() {

    }

    public function postSave() {
        $cmd = $this->getCmd(null, 'niveau');
        if (!is_object($cmd)) {
            $cmd = new SoundLevel();
            $cmd->setLogicalId('niveau');
            $cmd->setIsVisible(1);
            $cmd->setName(__('niveau', __FILE__));
        }
        $cmd->setType('info');
        $cmd->setSubType('numeric');
        $cmd->setEqLogic_id($this->getId());
        $cmd->setDisplay('generic_type', 'ENERGY_STATE');
        $cmd->save();

        $infos = $this->getInfo();
        $this->updateInfo();
    }

    public function preUpdate() {
      if ($this->getConfiguration('carte audio') == '') {
                  throw new Exception(__('La carte audio doit etre renseignée, tapez la commande arecord -l pour identifier', __FILE__));
              }
    }

    public function postUpdate() {

    }

    public function preRemove() {

    }

    public function postRemove() {

    }

    /*
     * Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
      public function toHtml($_version = 'dashboard') {

      }
     */

    /*
     * Non obligatoire mais ca permet de déclancher une action après modification de variable de configuration
    public static function postConfig_<Variable>() {
    }
     */

    /*
     * Non obligatoire mais ca permet de déclancher une action avant modification de variable de configuration
    public static function preConfig_<Variable>() {
    }
     */

    public function getInfo() {
        $this->checkSoundLevelStatus();

        $power_state=shell_exec("sudo sh ../../3rparty/SPL.sh");

        return array('power_state' => $power_state);
    }

    public function updateInfo() {
        try {
            $infos = $this->getInfo();
        } catch (Exception $e) {
            return;
        }

        if (!is_array($infos)) {
            return;
        }

        if (isset($infos['niveau'])) {
            $this->checkAndUpdateCmd('niveau', $infos['niveau']);
        }

        throw new Exception(var_dump($infos), 1);
    }

    public function checkSoundLevelStatus() {
        #$check=shell_exec("sudo adb devices | grep ".$this->getConfiguration('ip')." | cut -f2 | xargs");
      	#echo $check;
        #if(strstr($check, "offline"))
        #    throw new Exception("Votre appareil est détectée 'offline' par ADB.", 1);
        #if(!strstr($check, "device")) {
            #shell_exec("sudo adb kill-server");
            #shell_exec("sudo adb start-server");
            #shell_exec("sudo adb connect ".$eqLogic->getConfiguration('ip'));
        #    throw new Exception("Votre appareil est non détectée par ADB.", 1);
        }
    }

    /*     * **********************Getteur Setteur*************************** */
}

class SoundLevel extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */

    public function execute($_options = array()) {
    }

    /*     * **********************Getteur Setteur*************************** */
}
