<?php
/**
* Filter input URL to strip certain characters
*/
// regex to match character to remove
$regex = "%81";

if (isset($_GET["url"])) {
    $url = $_GET["url"];
    $handle = fopen($url, "r");
    if ($handle) {
        while (!feof($handle)) {
            $line = fgets($handle);
//            echo urldecode(preg_replace('/'.$regex.'/', "", urlencode($line)));
            echo filter_var($line,FILTER_UNSAFE_RAW,FILTER_FLAG_ENCODE_HIGH);
            
        }
        fclose($handle);
    }
}
else {
echo '<html><body><form name="input" method="get">
URL: <input type="text" name="url" value="http://www.data.gov/data_gov_catalog.csv" /><br />
<input type="submit" value="Submit" /></form></body></html>';
}
?>
