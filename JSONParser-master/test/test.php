<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'package/JSONParser.php';

error_reporting(E_ALL);

$GLOBALS['currentObjSt'] = false;
$GLOBALS['currentObjListings'] = false;
$GLOBALS['currentObjSingleListing'] = false;
$GLOBALS['isInListings'] = false;

function objStart($value, $property) {
	if(!$GLOBALS['isInListings']) $GLOBALS['currentObjSt'] = array();
	else $GLOBALS['currentObjSingleListing'] = array();
}

function objEnd($value, $property) {
		
	print_r($GLOBALS['benjy']);
	echo "<BR>";
}

function arrayStart($value, $property) {
	$GLOBALS['benjy'] = array();
	//printf("[<br>");
}

function arrayEnd($value, $property) {
	//printf("]<br>");
	print_r($GLOBALS['benjy']);
	echo "<BR>";
}

function value($value, $property) {
	
	if($GLOBALS['currentObjSt']&&(!$GLOBALS['isInListings'])) $GLOBALS['currentObjSt'][$property]=$value;
	else if($GLOBALS['currentObjSingleListing']) $GLOBALS['currentObjSingleListing'][$property] = $value;

	//$GLOBALS['benjy'][$property] = $value;
}

function property($value, $property) {
	//printf("Property: %s\n", $value);
	value($value, $property);
}

function scalar($value, $property) {
	//printf("Value: %s\n", $value);
	value($value, $property);
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
