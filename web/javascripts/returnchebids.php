<?php
/*
#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
import os
import json
#SUDS for SOAP web services stuff
import logging
from suds.client import Client
logging.basicConfig(level=logging.INFO)
#logging.getLogger('suds.client').setLevel(logging.DEBUG) #Enabling specific module logging mode of suds to debug

#Script que recibe el nombre de un organismo y devuelve un json con la siguiente estructura:
#{"CHEBI:491858": "1,4-dihydroxynaphthalene bis(beta-D-xylopyranoside)", "CHEBI:34063": "naphthalene-1,4-diol"}


#Creamos  un cliente para el servicio a partir del WSDL
url = 'http://www.ebi.ac.uk/webservices/chebi/2.0/webservice?wsdl'
client = Client(url)

compoundName=sys.argv[1]
arrayChebiIds={}

#############################################################################
entities=client.service.getLiteEntity(compoundName,'chebiId',200,'ALL')
#############################################################################
try:
	listElements=entities[0]
except:
	sys.exit()
for liteEntity in listElements:
    chebiId=liteEntity["chebiId"]
    #Tenemos el chebiId y podemos llamar al servicio getCompleteEntity(str(chebiId)). Para ello hacemos:
    completeEntity=client.service.getCompleteEntity(str(chebiId))
    nombreCompuesto=str(completeEntity[1])
    arrayChebiIds[chebiId]=nombreCompuesto

#Generamos un json para poder devolver a php
arrayJson=json.dumps(arrayChebiIds)
print arrayJson
sys.exit()
*/
$compoundName="3-hydroxy-2-methylbutanoic acid";
$arrayChebiIds=array();
$a = "3-hydroxy-2-methylbutanoic acid";
$b = 'CHEBI NAME';
$c = 2;
$d="ALL";
try{
    $client = new SoapClient("http://www.ebi.ac.uk/webservices/chebi/2.0/webservice?wsdl", array("trace" => 1));
    //$client->getLiteEntity($a, $b, $c, $d);
    //$entities = $client->__soapCall("getLiteEntity", array("search" => $a, "searchCategory" => $b, "maximumResults" => $c, "stars" => $d));
    $entities = $client->getLiteEntity(array("search" => $a, "searchCategory" => $b, "maximumResults" => $c, "stars" => $d));

    //print_r($entities);

    $arrayEntities = get_object_vars($entities);
    $arrayEn=get_object_vars($arrayEntities['return']);
    $arrayListObjs=$arrayEn['ListElement'];
    foreach($arrayListObjs as $obj){
        $chebiId=$obj->chebiId;
        array_push($arrayChebiIds, $chebiId);
    }

    $jsonString = json_encode($arrayChebiIds);
    print $jsonString;
    exit();
} catch(SoapFault $e){
 var_dump($e);
}

?>