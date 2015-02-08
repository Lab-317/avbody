<?php

class connexion extends PDO
{
  public $query = null;
  function __construct() {
    
     $options = null;
     parent::__construct("mysql:host=140.115.82.188;dbname=avno2;charset=utf-8","root","lab317", $options);
     $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $this->exec('SET NAMES utf8 COLLATE utf8_unicode_ci');
     $this->query('SET NAMES "utf8"');
	
  }
   public function prepare($sql) {
    $stmt = parent::prepare($sql);

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt;
  }
  public function last_query()
  {
    return $this->query;
  }
}

class connexion_statement extends PDOStatement
{
  protected $pdo;
  protected function __construct($pdo)
  {
     $this->pdo = $pdo;
  }
  // return first column of first row
  public function fetchFirst()
  {
    $row = $this->fetch( PDO::FETCH_NUM );
    return $row[0];
  }
  // real cast number
  public function fetch( $fetch_style = null, $cursor_orientation = null, $cursor_offset = null )
  {
    $row = parent::fetch( $fetch_style, $cursor_orientation, $cursor_offset );
    if( is_array($row) )
      foreach( $row as $key => $value )
        if( strval(intval($value)) === $value )
          $row[$key] = intval($value);
        elseif( strval(floatval($value)) === $value )
          $row[$key] = floatval($value);
    return $row;
  }
  // permit $prepare->execute( $arg1, $arg2, ... );
  public function execute( $args = null )
  {
    if( is_array( $args ) )
      return parent::execute( $args );
    else
    {
      $args = func_get_args();
      return eval( 'return parent::execute( $args );' );
    }
  }
  public function last_query()
  {
    return $this->pdo->last_query();
  }
}

