<?php

class KingfisherInstagram_Settings extends PerchAPI_Factory
{
    protected $table     = 'instagram_settings';
	protected $pk        = 'settingID';
	protected $singular_classname = 'KingfisherInstagram_Setting';
	
	protected $default_sort_column = 'settingID';
    
  public function find($id=false) 
  {
  $sql = 'SELECT * FROM '.PERCH_DB_PREFIX.'instagram_settings LIMIT 1';
  
  $row = $this->db->get_row($sql);


		// monkey patch
		if (is_array($row)) {
			if (!array_key_exists('settingUpdateInterval', $row)) {
				$sql = 'ALTER TABLE `'.PERCH_DB_PREFIX.'instagram_settings` ADD `settingUpdateInterval` INT(10)  UNSIGNED  NOT NULL  DEFAULT \'0\'  AFTER `settingInstagramID`';
				$this->db->execute($sql);
				$row['settingUpdateInterval'] = 0;
			}

			if (!array_key_exists('settingInstagramToken', $row)) {

				$sql = 'ALTER TABLE `'.PERCH_DB_PREFIX.'instagram_settings` ADD `settingInstagramToken` VARCHAR(255)  NOT NULL  DEFAULT \'\'  AFTER `settingUpdateInterval`';
				$this->db->execute($sql);
      }
    }else{

			$this->attempt_install();

			$this->db->execute('INSERT INTO `'.PERCH_DB_PREFIX.'instagram_settings` (settingUpdateInterval) VALUES (\'\')');
			return $this->find($id);
		}

  return $this->return_instance($row);
  }
}