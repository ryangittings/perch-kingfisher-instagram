<?php
    // Prevent running directly:
    if (!defined('PERCH_DB_PREFIX')) exit;

    // Let's go
    $sql = "
    CREATE TABLE IF NOT EXISTS `__PREFIX__instagram_posts` (
      `postID` int(11) NOT NULL AUTO_INCREMENT,
      `postInstagramID` varchar(255) NOT NULL DEFAULT '',
      `postImageStandard` varchar(255) NOT NULL DEFAULT '',
      `postImageThumbnail` varchar(255) NOT NULL DEFAULT '',
      `postImageLow` varchar(255) NOT NULL DEFAULT '',
      `postLink` varchar(255) NOT NULL DEFAULT '',
      `caption` varchar(255) NOT NULL DEFAULT '',
      `likes` varchar(255) NOT NULL DEFAULT '',
      `postDate` datetime DEFAULT NULL,
      PRIMARY KEY (`postID`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

    CREATE TABLE IF NOT EXISTS `__PREFIX__instagram_settings` (
      `settingID` int(11) NOT NULL AUTO_INCREMENT,
      `settingUpdateInterval` int(10) unsigned NOT NULL DEFAULT '0',
      `settingInstagramToken` varchar(255) NOT NULL DEFAULT '',
      PRIMARY KEY (`settingID`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
        
    INSERT INTO `__PREFIX__Instagram_settings` (settingInstagramID) VALUES ('')";
    
    $sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);
    
    $statements = explode(';', $sql);
    foreach($statements as $statement) {
        $statement = trim($statement);
        if ($statement!='') $this->db->execute($statement);
    }
        
    $sql = 'SHOW TABLES LIKE "'.$this->table.'"';
    $result = $this->db->get_value($sql);
    
    return $result;
