<?php

class KingfisherInstagram_Posts extends PerchAPI_Factory
{
  protected $table     = 'instagram_posts';
	protected $pk        = 'postID';
	protected $singular_classname = 'KingfisherInstagram_Post';
	
	protected $default_sort_column = 'postID';
  protected $default_sort_direction = 'DESC';
    
	public function get_post_ids()
  {
      $sql = 'SELECT postInstagramID 
              FROM '.PERCH_DB_PREFIX.'instagram_posts';
      

      $rows   = $this->db->get_rows($sql);
      $a = array();
      if(is_array($rows)) {
        foreach($rows as $row) {
          $a[] = $row['postInstagramID'];
        }
      }
      
      return $a;
  }
}