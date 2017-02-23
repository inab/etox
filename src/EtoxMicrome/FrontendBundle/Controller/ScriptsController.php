<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ScriptsController extends Controller
{
    public function autocompleteAction()
    {
        //$connection = $this->getDoctrine()->getConnection();
        $user = $this->getDoctrine()->getConnection()->getUsername();
        $password = $this->getDoctrine()->getConnection()->getPassword();
        $host = $this->getDoctrine()->getConnection()->getHost();

        $request = $this->getRequest();
        $term = $request->query->get('term');

        $conn = mysql_connect ($host, $user, $password);
        mysql_select_db("Limtox", $conn);
        mysql_query("SET NAMES 'utf8'");
        $selectSQL="select distinct(nombre), id from Entidad where lower(nombre) like lower('%$term%')";
        #print $selectSQL;
        $result= mysql_query($selectSQL);
        $arr=array();
        while ($row = mysql_fetch_row($result)){
        	#$idEnzyme=$row[0];
        	$textminingName=$row[0];
        	$id=$row[1];
        	$arrayTmp=array("label"=>$textminingName,"value"=>$textminingName);
        	$arr[]=$arrayTmp;
        }
        $jsonString = json_encode($arr);
        print $jsonString;
        exit();
    }
}
