<?php
require_once (__DIR__) . DIRECTORY_SEPARATOR . 'JSONParser-master/package/JSONParser.php';
require_once('dataBase.php');
//$mysqli = connect();




ini_set('memory_limit', '1024M');
error_reporting(E_ALL);
ini_set('display_errors','On');
ini_set('max_execution_time',600000);


$GLOBALS['currentObjSt'] = false;
$GLOBALS['currentObjListings'] = false;
$GLOBALS['currentObjSingleListing'] = false;
$GLOBALS['isInListings'] = false;

function print_a_global($str) {
  echo $str.":".print_r($GLOBALS[$str],true)."<br>";
}

function nadilog() {
  print_a_global('currentObjSt');
  print_a_global('currentObjListings');
  print_a_global('currentObjSingleListing');

}

function objStart($value, $property) {
	if(!$GLOBALS['isInListings']) $GLOBALS['currentObjSt'] = array();
	else if($GLOBALS['isInListings']) {
	  $GLOBALS['currentObjSingleListing']=array();
	}
	else $GLOBALS['currentObjSingleListing'] = array();

}

function objEnd($value, $property) {
    
		if(!$GLOBALS['isInListings']){
  		
		  //nadilog();
		  
		}
		else {
		  insertListingFromObject($GLOBALS['currentObjSingleListing'] );
		  //print_a_global('currentObjSingleListing');
		
		}
    
}

function arrayStart($value, $property) {

	$GLOBALS['currentObjListings']=array();

}

function arrayEnd($value, $property) {

	if($GLOBALS['isInListings']){
	  $GLOBALS['isInListings']=false;

	  
	}

}

function value($property,$value) {

	if($value=="listings") {

	  $GLOBALS['isInListings'] =true;
    
	}
	$a = is_array($GLOBALS['currentObjSt']);
	$b = !$GLOBALS['isInListings'];

	if($a&&$b) {

	  $GLOBALS['currentObjSt'][$property]=$value;
	}
	else if(is_array($GLOBALS['currentObjSingleListing'])) $GLOBALS['currentObjSingleListing'][$property] = $value;



	//$GLOBALS['benjy'][$property] = $value;
}

function property($property,$value) {
	//printf("Property: %s\n", $value);
	//value($value, $property);
	if($property=="listings") {
	  $GLOBALS['isInListings']=true;
	}
	//echo $property.":".$value."   YOOOOO!!!####";
 }

function scalar($value, $property) {
	//printf("Value: %s\n", $value);
	value($property, $value);
}








	function addPossibleCategory($category) {
		$link = dao::mysqliObj();
        $query = 'insert into commodities_category set ' .
                 'id = "'.mysqli_real_escape_string($link,$category["id"]).'", ' .
                'name = "'.mysqli_real_escape_string($link,$category["name"]).'"';
        $res = dao::query($query);
	}
	
	function addCommodity($commodity) {
		$link = dao::mysqliObj();
	 	$query = 'insert into commodities set ' .
                 'id = "'.mysqli_real_escape_string($link,$commodity["id"]).'", ' .
                'name = "'.mysqli_real_escape_string($link,$commodity["name"]).'", ' .
                'category_id = "'.mysqli_real_escape_string($link,$commodity["category_id"]).'", ' .
                'average_price = "'.mysqli_real_escape_string($link,$commodity["average_price"]).'"';
        $res = dao::query($query);
	}
	
	
	function addSystem($system) {
		$link = dao::mysqliObj();
	 	$query = 'insert into systems set ' .
                 'id = "'.mysqli_real_escape_string($link,$system["id"]).'", ' .
                'name = "'.mysqli_real_escape_string($link,$system["name"]).'", ' .
                'x = "'.mysqli_real_escape_string($link,$system["x"]).'", ' .
                'y = "'.mysqli_real_escape_string($link,$system["y"]).'", ' .
                'z = "'.mysqli_real_escape_string($link,$system["z"]).'", ' .
                'faction = "'.mysqli_real_escape_string($link,$system["faction"]).'", ' .
                'population = "'.mysqli_real_escape_string($link,$system["population"]).'", ' .
                'government = "'.mysqli_real_escape_string($link,$system["government"]).'", ' .
                'allegiance = "'.mysqli_real_escape_string($link,$system["allegiance"]).'", ' .
                'state = "'.mysqli_real_escape_string($link,$system["state"]).'", ' .
                'security = "'.mysqli_real_escape_string($link,$system["security"]).'", ' .
                'primary_economy = "'.mysqli_real_escape_string($link,$system["primary_economy"]).'"';
        $res = dao::query($query);
	}
        
        function addStation($station) {
        	$link = dao::mysqliObj();
            $query = 'insert into stations set ' .
                   'id = "'.mysqli_real_escape_string($link,$station["id"]).'", ' .
                   'name = "'.mysqli_real_escape_string($link,$station["name"]).'", ' .
                   'system_id = "'.mysqli_real_escape_string($link,$station["system_id"]).'", ' .
                   'has_blackmarket = "'.mysqli_real_escape_string($link,$station["has_blackmarket"]).'", ' .
                   'max_landing_pad_size = "'.mysqli_real_escape_string($link,$station["max_landing_pad_size"]).'", ' .
                   'distance_to_star = "'.mysqli_real_escape_string($link,$station["distance_to_star"]).'", ' .
                   'faction = "'.mysqli_real_escape_string($link,$station["faction"]).'", ' .
                   'government = "'.mysqli_real_escape_string($link,$station["government"]).'", ' .
                   'allegiance = "'.mysqli_real_escape_string($link,$station["allegiance"]).'", ' .
                   'state = "'.mysqli_real_escape_string($link,$station["state"]).'", ' .
                   'type = "'.mysqli_real_escape_string($link,$station["type"]).'", ' .
                   'has_commodities = "'.mysqli_real_escape_string($link,$station["has_commodities"]).'", ' .
                   'has_refuel = "'.mysqli_real_escape_string($link,$station["has_refuel"]).'", ' .
                   'has_repair = "'.mysqli_real_escape_string($link,$station["has_repair"]).'", ' .
                   'has_outfitting = "'.mysqli_real_escape_string($link,$station["has_outfitting"]).'", ' .
                   'has_shipyard = "'.mysqli_real_escape_string($link,$station["has_shipyard"]).'"';
            $res = dao::query($query);
	}
        
        function addListing($listing) {
        	$link = dao::mysqliObj();
            $query = 'insert into stations_listings set ' .
                   'id = "'.mysqli_real_escape_string($link,$listing["id"]).'", ' .
                   'station_id = "'.mysqli_real_escape_string($link,$listing["station_id"]).'", ' .
                   'commodity_id = "'.mysqli_real_escape_string($link,$listing["commodity_id"]).'", ' .
                   'supply = "'.mysqli_real_escape_string($link,$listing["supply"]).'", ' .
                   'buy_price = "'.mysqli_real_escape_string($link,$listing["buy_price"]).'", ' .
                   'sell_price = "'.mysqli_real_escape_string($link,$listing["sell_price"]).'", ' .   
                   'collected_at = "'.mysqli_real_escape_string($link,$listing["collected_at"]).'"';
            $res = dao::query($query);
	}
	
	function importCommodities() {
		$commodities = json_decode(file_get_contents("http://eddb.io/archive/v2/commodities.json"),true);
		$commodityCategories = array();
		foreach($commodities as $commodity) {
			addPossibleCategory($commodity["category"]);
			addCommodity($commodity);
		}
	}
	
	//print_r($commoditiesRaw);
	
	
	
	function importSystems() {
		$systems = json_decode(file_get_contents("http://eddb.io/archive/v2/systems.json"),true);
		foreach($systems as $system) {
			addSystem($system);
		}
		//print_r($systems);
	}
	
function addEcon($econ_name){
        $queryId = "select id from economies where economy_name = '".$econ_name."'";
        $econ = dao::query($queryId);
		if(!$econ->fetch_assoc()){
            $queryInsert = "insert into economies (`economy_name`) values ('".$econ_name."')";
            dao::query($queryInsert);
            $econ = dao::query($queryId);
       

        }
		$econId = $econ->fetch_assoc();
       	$econ_id = $econId['id'];


		return $econ_id;
	}
	
	function addStationEcon($station_id,$econ_name){

    	$econ_id = addEcon($econ_name);	
    	if(!$econ_id){
    		$queryId = "select id from economies where economy_name = '".$econ_name."'"; // another id check
    		$temp = dao::query($queryId);
    		$temp = $temp->fetch_assoc();
    		$econ_id = $temp['id'];
    	}
 
    	$query = "insert into station_economies (`station_id`,`economy_id`) values ('".$station_id."','".$econ_id."')";

    	dao::query($query);
	}
	function commodityId($name){
			$queryId = "select id from commodities where name = '".$name."'";
			$commodity_id= dao::query($queryId);

    		$temp = $commodity_id->fetch_assoc();
    		$commodity_id = $temp['id'];
    		return $commodity_id;	
	}

	function addStationImportCommodities($station_id,$import){
		$commodity_id = commodityId($import);
		
		if($commodity_id){
			$insertQuery = "insert into station_import_commodities (`station_id`,`commodity_id`) values ('".$station_id."','".$commodity_id."')";
			dao::query($insertQuery);
		}

	}
	function addStationExportCommodities($station_id,$export){
		$commodity_id = commodityId($export);
		
		if($commodity_id){
			$insertQuery = "insert into station_export_commodities (`station_id`,`commodity_id`) values ('".$station_id."','".$commodity_id."')";
			dao::query($insertQuery);
		}
		
	}

	function addStationProhibitedCommodities($station_id,$prohibited){
		$commodity_id = commodityId($prohibited);
		
		if($commodity_id){
			$insertQuery = "insert into station_prohibited_commodities (`station_id`,`commodity_id`) values ('".$station_id."','".$commodity_id."')";
			dao::query($insertQuery);
		}
		
	}

	
	function importStations() {
		$stationsStr = file_get_contents("http://eddb.io/archive/v2/stations_lite.json");
		$stations = json_decode($stationsStr,true);
            foreach($stations as $station) {
            //	print_r($station);
                  addStation($station);
                foreach($station['economies'] as $econ) {
                 	addStationEcon($station['id'],$econ);
            	}	
            	foreach ($station['import_commodities'] as  $import) {
            		addStationImportCommodities($station['id'],$import);
            	}
            	foreach ($station['export_commodities'] as  $export) {
            		addStationExportCommodities($station['id'],$export);
            		
            	}
            	foreach ($station['prohibited_commodities'] as  $prohib) {
            		addStationProhibitedCommodities($station['id'],$prohib);
            	}
            }
        }
	
	function deleteOldData() {
		dao::query("delete from commodities");
		dao::query("delete from commodities_category");
		dao::query("delete from stations");
		dao::query("DROP TABLE IF EXISTS `stations_listings`");
		dao::query("CREATE TABLE `stations_listings` ( `id` int(255) NOT NULL, `station_id` int(255) NOT NULL, `commodity_id` int(255) NOT NULL, `supply` int(255) NOT NULL, `buy_price` int(255) NOT NULL, `sell_price` int(255) NOT NULL, `demand` int(255) NOT NULL, `collected_at` int(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1");
		dao::query("delete from systems");
		dao::query("DROP TABLE IF EXISTS `station_economies`");
		dao::query("DROP TABLE IF EXISTS `economies`");
		dao::query("CREATE TABLE `economies` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT,`economy_name` varchar(64) NOT NULL,PRIMARY KEY (`id`),UNIQUE KEY `unique_economy_name` (`economy_name`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		dao::query("CREATE TABLE `station_economies` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `station_id` int(11) NOT NULL, `economy_id` int(11) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		dao::query("DROP TABLE IF EXISTS `station_export_commodities`");
		dao::query("CREATE TABLE `station_export_commodities` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `station_id` int(11) NOT NULL, `commodity_id` int(11) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		dao::query("DROP TABLE IF EXISTS `station_import_commodities`");
		dao::query("CREATE TABLE `station_import_commodities` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `station_id` int(11) NOT NULL, `commodity_id` int(11) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		dao::query("DROP TABLE IF EXISTS `station_prohibited_commodities`");
		dao::query("CREATE TABLE `station_prohibited_commodities` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `station_id` int(11) NOT NULL, `commodity_id` int(11) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
	}
	

	
	
	
		deleteOldData();
		echo 'Deleted old data/n';
        importCommodities();
        echo 'Imported Commodities/n';
        
        importSystems();
        echo 'Imported Systems/n';
		importStations();
		echo "imported stations and import/export/prohibited";
	
	
	// initialise the parser object
$parser = new JSONParser();

// sets the callbacks
$parser->setArrayHandlers('arrayStart', 'arrayEnd');
$parser->setObjectHandlers('objStart', 'objEnd');
$parser->setPropertyHandler('property');
$parser->setScalarHandler('scalar');

//echo "Parsing top level object document...\n";
// parse the document
//$parser->parseDocument(__DIR__ . '/data.json');

$parser->initialise();

//echo "Parsing top level array document...\n";
// parse the top level array

$parser->parseDocument('http://eddb.io/archive/v2/stations.json');