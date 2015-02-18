<?php
  function insertListingFromObject($obj){
    $string = "INSERT INTO stations_listings (`id`,`station_id`,`commodity_id`,`supply`,`buy_price`,`sell_price`,`demand`,`collected_at`) VALUES('";
    foreach($obj as $value){
      $string.=$value."','";
    }
    $string = substr($string, 0, -2);
    $string.=")";
    dao::query($string);
   // echo $string;
   // echo "<br>";

  }
  
  
  
  
  
	class dao {
		
		private static $connection = false;
		
		public static function connect() {
			if(self::$connection) return true;
			self::$connection = new mysqli("localhost","root","","eddb");
		    if (self::$connection->connect_error) {
		      die('Connect Error (' . self::$connection->connect_errno . ') '
		            . self::$connection->connect_error);
		    }
		    return true;
		}
		
        public static function query($query) {
        	if(!self::$connection) self::connect();
	        $result = self::$connection->query($query);
	        return $result;
	    }
	    public static function mySqliObj() {
        	if(!self::$connection) self::connect();
	       	return self::$connection;
	    }
	}
	
	
	dao::query('some kind of SQL query');
	dao::query('another SQL query');  

?>