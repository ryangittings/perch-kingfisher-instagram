<?php

class KingfisherInstagram_Setting extends PerchAPI_Base
{
    protected $table  = 'instagram_settings';
    protected $pk     = 'settingID';


    public function update($data)
    {
        
        // Update the data
        parent::update($data);

        
 		return true;
    }
    
    

}
