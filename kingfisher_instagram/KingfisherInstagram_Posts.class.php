<?php

class KingfisherInstagram_Posts extends PerchAPI_Factory
{
  protected $table     = 'instagram_posts';
	protected $pk        = 'postID';
	protected $singular_classname = 'KingfisherInstagram_Post';
	
  protected $default_sort_column = 'postDate';
  protected $default_sort_direction = 'DESC';

  public function get_custom($opts)
    {
        $sql = 'SELECT * 
                FROM '.$this->table;

        if (isset($opts['count'])) {
          $count = (int) $opts['count'];

          if (isset($opts['start'])) {
                $start = (((int) $opts['start'])-1). ',';
          }else{
              $start = '';
          }

          $limit = $start.$count;
          
          if ($filter_type=='sql' && $Paging->enabled()) {
            $sql .= ' '.$Paging->limit_sql();
          }else{
              if ($limit && $limit!='') {
                $sql .= ' LIMIT '.$limit;
            }
          }
      }

        $row = $this->db->get_rows($sql);
        
        return $this->return_instances($row);
    }
    
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