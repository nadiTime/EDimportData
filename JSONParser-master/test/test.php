<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'package/JSONParser.php';

error_reporting(E_ALL);
ini_set('display_errors','On');
ini_set('max_execution_time',5);
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
  print_a_global('isInListings');
}

function objStart($value, $property) {
  echo "<hr>";
	if(!$GLOBALS['isInListings']) $GLOBALS['currentObjSt'] = array();
	else if($GLOBALS['isInListings']) {
	  echo "single listings = array";
	  $GLOBALS['currentObjSingleListing']=array();
	}
	else $GLOBALS['currentObjSingleListing'] = array();
	echo "objStart()";
	nadilog();
}

function objEnd($value, $property) {
		echo "<hr>";
		if(!$GLOBALS['isInListings']){
		  nadilog();
		  
		}
		echo "objEnd()";
    
}

function arrayStart($value, $property) {
	echo "<hr>";
	$GLOBALS['currentObjListings']=array();
	echo "arrayStart()";
  nadilog();
}

function arrayEnd($value, $property) {
	//printf("]<br>");
	echo "<hr>";
	if($GLOBALS['isInListings']){
	  $GLOBALS['isInListings']=false;
	  var_dump($GLOBALS['currentObjSingleListing']);
	  
	}
	echo "arrayEnd()";
	
  nadilog();
}

function value($property,$value) {
  echo "<hr>";
	if($value=="listings") {
	  echo "property = listings";
	  $GLOBALS['isInListings'] =true;
    
	}
	$a = is_array($GLOBALS['currentObjSt']);
	$b = !$GLOBALS['isInListings'];

	if($a&&$b) {
    echo "its working";
	  $GLOBALS['currentObjSt'][$property]=$value;
	}
	else if(is_array($GLOBALS['currentObjSingleListing'])) $GLOBALS['currentObjSingleListing'][$property] = $value;
	  echo "value() ".$property." => ".$value."<br>";
    nadilog();

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
