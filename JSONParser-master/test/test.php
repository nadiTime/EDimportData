<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'package/JSONParser.php';
require_once('dataBase.php');
$mysqli = connect();
$delete = $mysqli->query("delete from stations_listings");
if($delete) echo "delete success";
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
$parser->parseDocument(__DIR__ . '/stations.json');
