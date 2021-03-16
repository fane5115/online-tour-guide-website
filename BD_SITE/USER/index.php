<?php
require("config.php");

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}



// Select all the rows in the markers table
$query = "SELECT * FROM informatii_locatie";
$result = mysqli_query($mysqli, $query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($mysqli));
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
$row = @mysqli_fetch_row($result);
  // Add to XML document node
  echo '<marker ';
  echo 'id="' . $row[0] . '" ';
  echo 'name="' . $row[1]. '" ';
  echo 'address="' . $row[2]. '" ';
  echo 'lat="' . $row[3] . '" ';
  echo 'lng="' . $row[4] . '" ';
  echo '/>';

// End XML file
echo '</markers>';

?>
