<?php

/**
 * Convert a CSV variable into an XML DOMDocument
 * Includes example usage and input form
 * Author: Michael Chelen http://mikechelen.com
 * License: released under Creative Commons Zero Public Domain http://creativecommons.org/publicdomain/zero/1.0/
 */
 
 /**
 * @param file pointer resource $handle
 * @param string $rootName
 * @param string $rowName
 * @return DOMDocument
 */
 
function csv2xml($handle, $rootName, $rowName) {
    $doc = new DOMDocument;
    $rootNode = $doc->createElement($rootName);
    $doc->appendChild($rootNode);
//  get column names
    $columnData = fgetcsv($handle, 0, ',');
//  go through each row    
    while (($data = fgetcsv($handle, 0, ',')) !== FALSE) {
        $rowNode = $doc->createElement($rowName);
        $rootNode->appendChild($rowNode);
//      loop through the fields in the row
        for ($i=0;($i<count($data))&&($i<count($columnData));$i++) {
//          strips illegal characters from node names
//          and encodes characters in the node content 
            $fieldNode = $doc->createElement(preg_replace('/[^a-zA-Z0-9]/',"",$columnData[$i]),htmlspecialchars(utf8_encode($data[$i])));
            $rowNode->appendChild($fieldNode);
        }
    }
    return $doc;
}
/**
 * example function usage
 */
//get inputs
$url = $_GET["url"];
$row = $_GET["row"];
$root = $_GET["root"];
if (isset($url)) {
    header('Content-Type: text/xml');
    $params = array('http' => array(
                      'method' => 'GET'
                      ));
    $ctx = stream_context_create($params);
    $handle = @fopen($url, 'rb', false, $ctx);
    $xml = csv2xml($handle,$root,$row);
    $xml->formatOutput=true;
    echo $xml->saveXML();
}
else {
    echo '<html><body><form name="input" method="get">
    URL: <input type="text" name="url" /><br />
    Row name: <input type="text" name="row" value="row" /><br />
    Root name: <input type="text" name="root" value="root" /><br />
    <input type="submit" value="Submit" /></form></body></html>';
}
?>
