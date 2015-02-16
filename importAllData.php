<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'package/JSONParser.php';
require_once('dataBase.php');
$mysqli = connect();
$delete = $mysqli->query("delete from stations_listings");
if($delete) echo "delete success";


ini_set('memory_limit', '1024M');
error_reporting(E_ALL);
ini_set('display_errors','On');
ini_set('max_execution_time',6000);


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
		  
		  echo "<hr>";
		}
		else {
		  createQuery($GLOBALS['currentObjSingleListing'] );
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








	function addPossibleCategory($category) {
        $query = 'insert into commodities_category set ' .
                 'id = "'.mysql_real_escape_string($category["id"]).'", ' .
                'name = "'.mysql_real_escape_string($category["name"]).'"';
        $res = dao::query($query);
	}
	
	function addCommodity($commodity) {
	 $query = 'insert into commodities set ' .
                 'id = "'.mysql_real_escape_string($commodity["id"]).'", ' .
                'name = "'.mysql_real_escape_string($commodity["name"]).'", ' .
                'category_id = "'.mysql_real_escape_string($commodity["category_id"]).'", ' .
                'average_price = "'.mysql_real_escape_string($commodity["average_price"]).'"';
        $res = dao::query($query);
	}
	
	
	function addSystem($system) {
	 $query = 'insert into systems set ' .
                 'id = "'.mysql_real_escape_string($system["id"]).'", ' .
                'name = "'.mysql_real_escape_string($system["name"]).'", ' .
                'x = "'.mysql_real_escape_string($system["x"]).'", ' .
                'y = "'.mysql_real_escape_string($system["y"]).'", ' .
                'z = "'.mysql_real_escape_string($system["z"]).'", ' .
                'faction = "'.mysql_real_escape_string($system["faction"]).'", ' .
                'population = "'.mysql_real_escape_string($system["population"]).'", ' .
                'government = "'.mysql_real_escape_string($system["government"]).'", ' .
                'allegiance = "'.mysql_real_escape_string($system["allegiance"]).'", ' .
                'state = "'.mysql_real_escape_string($system["state"]).'", ' .
                'security = "'.mysql_real_escape_string($system["security"]).'", ' .
                'primary_economy = "'.mysql_real_escape_string($system["primary_economy"]).'"';
        $res = dao::query($query);
	}
        
        function addStation($station) {
            $query = 'insert into stations set ' .
                   'id = "'.mysql_real_escape_string($station["id"]).'", ' .
                   'name = "'.mysql_real_escape_string($station["name"]).'", ' .
                   'system_id = "'.mysql_real_escape_string($station["system_id"]).'", ' .
                   'has_blackmarket = "'.mysql_real_escape_string($station["has_blackmarket"]).'", ' .
                   'max_landing_pad_size = "'.mysql_real_escape_string($station["max_landing_pad_size"]).'", ' .
                   'distance_to_star = "'.mysql_real_escape_string($station["distance_to_star"]).'", ' .
                   'faction = "'.mysql_real_escape_string($station["faction"]).'", ' .
                   'government = "'.mysql_real_escape_string($station["government"]).'", ' .
                   'allegiance = "'.mysql_real_escape_string($station["allegiance"]).'", ' .
                   'state = "'.mysql_real_escape_string($station["state"]).'", ' .
                   'type = "'.mysql_real_escape_string($station["type"]).'", ' .
                   'has_commodities = "'.mysql_real_escape_string($station["has_commodities"]).'", ' .
                   'has_refuel = "'.mysql_real_escape_string($station["has_refuel"]).'", ' .
                   'has_repair = "'.mysql_real_escape_string($station["has_repair"]).'", ' .
                   'has_outfitting = "'.mysql_real_escape_string($station["has_outfitting"]).'", ' .
                   'has_shipyard = "'.mysql_real_escape_string($station["has_shipyard"]).'"';
            $res = dao::query($query);
	}
        
        function addListing($listing) {
            $query = 'insert into stations_listings set ' .
                   'id = "'.mysql_real_escape_string($listing["id"]).'", ' .
                   'station_id = "'.mysql_real_escape_string($listing["station_id"]).'", ' .
                   'commodity_id = "'.mysql_real_escape_string($listing["commodity_id"]).'", ' .
                   'supply = "'.mysql_real_escape_string($listing["supply"]).'", ' .
                   'buy_price = "'.mysql_real_escape_string($listing["buy_price"]).'", ' .
                   'sell_price = "'.mysql_real_escape_string($listing["sell_price"]).'", ' .   
                   'collected_at = "'.mysql_real_escape_string($listing["collected_at"]).'"';
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
	
	
	
	
	function importStations() {
		$stationsStr = file_get_contents("http://eddb.io/archive/v2/stations_lite.json");
		$stations = json_decode($stationsStr,true);
                foreach($stations as $station) {
                	print_r($station);
                    addStation($station);
                }
                
                $parser->parseDocument('http://eddb.io/archive/v2/stations.json');

	}
	
	function deleteOldData() {
		dao::query("delete from commodities");
		dao::query("delete from commodities_category");
		dao::query("delete from stations");
		dao::query("delete from systems");
	}
	

	
	
	
		deleteOldData();
		echo 'Deleted old data/n';
        importCommodities();
        echo 'Imported Commodities/n';
        
        importSystems();
         echo 'Imported Systems/n';
	importStations();