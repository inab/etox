<?php
include("config.php");
$term = $_GET['term'];
$searchfor = $_GET['searchfor'];
switch ($searchfor) {
    case "enzymes":
        $searchfor="enzyme";
        break;
    case "compounds":
        $searchfor="compound";
        break;
    case "species":
        $searchfor="organism";
        break;
}

$conn = mysql_connect ($database, $db_user, $db_password);
mysql_select_db("EtoxMicromeTebacten", $conn);
mysql_query("SET NAMES 'utf8'");
$selectSQL="select distinct(textmining_".$searchfor."_name) from ".$searchfor."s where textmining_".$searchfor."_name like '%$term%'";
#print $selectSQL;
$result= mysql_query($selectSQL);
$arr=array();
while ($row = mysql_fetch_row($result)){
	#$idEnzyme=$row[0];
	$textminingEnzymeName=$row[0];
	$arrayTmp=array("label"=>$textminingEnzymeName,"value"=>$textminingEnzymeName);
	$arr[]=$arrayTmp;
}
$jsonString = json_encode($arr);
print $jsonString;
exit();
#$jsonString=implode(",",$arr);
#jsonString="[$jsonString];";
#print $jsonString
?>