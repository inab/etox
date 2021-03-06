<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TanimotoValuesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TanimotoValuesRepository extends EntityRepository
{
	public function getCompoundsWithTanimotos($idCompound){
    	//ld($idCompound);
		$query = $this->_em->createQuery("
            SELECT tv
            FROM EtoxMicromeEntityBundle:TanimotoValues tv
            WHERE tv.compound1= :idCompound
            OR tv.compound2= :idCompound
            AND tv.tanimoto >= 0.8
            ORDER BY tv.tanimoto DESC
        ");
        $query->setParameter('idCompound', $idCompound);
        $arrayTanimotos=$query->getResult();
        return $arrayTanimotos;
    }

    public function findCompounds2Compounds2FromCompound($idCompound, $dictionaryCompounds){
        $arrayTmp=array();
        $save=false;
    	$query = $this->_em->createQuery("
            SELECT tv
            FROM EtoxMicromeEntityBundle:TanimotoValues tv
            WHERE tv.tanimoto >= 0.9
            AND (tv.compound1= :idCompound OR tv.compound2= :idCompound)
            ORDER BY tv.tanimoto DESC

        ");
        $query->setParameter('idCompound', $idCompound);
        $query->setMaxResults(20);
        $arrayTanimotos=$query->getResult();
        //We iterate over arrayTanimotos to search the compounds related
        foreach($arrayTanimotos as $tanimoto){
            if($idCompound!=$tanimoto->getCompound1()->getId()){
                $compoundName=$tanimoto->getCompound1()->getName();
                $tanimotoValue=$tanimoto->getTanimoto();
                $save=true;
            }elseif($idCompound!=$tanimoto->getCompound2()->getId()){
                $compoundName=$tanimoto->getCompound2()->getName();
                $tanimotoValue=$tanimoto->getTanimoto();
                $save=true;
            }
            if(($save==true) and (array_key_exists($compoundName, $dictionaryCompounds))){
                $arrayTmp[$compoundName]=$tanimotoValue;
                $save=false;
            }
        }
        return $arrayTmp;
    }

    public function sortArrayByTanimoto($arrayTanimotos){
    	$arrayTmp=array();
    	//First of all we generate an array with id=idTanimotoValue, tanimoto=tanimotoValue. So we can sort it with array_multisort
    	foreach($arrayTanimotos as $tanimotoValues){
	    	$idTmp=$tanimotoValues->getId();
	    	$tanimotoTmp=$tanimotoValues->getTanimoto();
	    	$arrayTmp[$idTmp]=$tanimotoTmp;
    	}
    	arsort($arrayTmp);
    	//Then we recreate the arrayTanimotos sorted.
    	$arrayDef=array();
    	foreach($arrayTmp as $key => $val){
    		$query = $this->_em->createQuery("
	            SELECT tv
	            FROM EtoxMicromeEntityBundle:TanimotoValues tv
	            WHERE tv.id= :key
	        ");
	        $query->setParameter('key', $key);
	        $tanimotoValue=$query->getResult();
    		array_push($arrayDef,$tanimotoValue[0]);
    	}
    	//We return just the first 10 elements of the array
        return array_slice($arrayDef, 0, 10);
    }

    public function hex2rgb($hex) {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       //return implode(",", $rgb); // returns the rgb values separated by commas
       return $rgb; // returns an array with the rgb values
    }

    public function rgb2hex($rgb)
    {
        //We have three positions [0]=red, [1]=green, [2]=blue
        return '#' . sprintf('%02x', $rgb[0]) . sprintf('%02x', $rgb[1]) . sprintf('%02x', $rgb[2]);
    }

    public function normalizeWeights($dictionaryCompounds){
        //We normalize all weights between 0-100
        //First we get max and min values:
        $max=max($dictionaryCompounds);
        $min=min($dictionaryCompounds);
        $dictionaryNormalizedWeights=array();
        foreach($dictionaryCompounds as $compound=>$weight){
            if($max==$min){
                $normalizedWeight=0;
            }
            else{
                $normalizedWeight=round(100*($weight-$min)/($max-$min),2);
            }
            $dictionaryNormalizedWeights[$compound]=$normalizedWeight;
        }
        return $dictionaryNormalizedWeights;
    }

    function percentToRGB($percent) {
        if ($percent == 100) {
            $percent = 99;
        }
        //var r, g, b;

        if ($percent < 50) {
            // green to yellow
            $r = floor(255 * ($percent / 50));
            $g = 255;

        } else {
            // yellow to red
            $r = 255;
            $g = floor(255 * ((50 - $percent % 50) / 50));
        }
        $b = 0;

        $arrayRGB=[$r,$g,$b];

        return $arrayRGB;
    }


    public function generateStringsForCytoscape($entityName, $entityType, $dictionaryRelations, $dictionaryTypeRelations){
        $message="generateStringsForCytoscape";
        //Next dictionaries are to load relations between entities and the other entities inside the interaction network
        $dictionaryCompoundRelations=array();
        $dictionaryTermRelations=array();
        $dictionaryTermTypeRelations=array();
        $dictionaryCypRelations=array();
        $dictionaryCypTypeRelations=array();
        $dictionaryMarkerRelations=array();
        $dictionaryMarkerTypeRelations=array();
        //At $dictionaryTypeRelations we have the type of relations for the direct edges between each entity

        $em = $this->getEntityManager();
        $stringNodes="";
        $stringEdges="";
        /*"dataSchema":
                        {"nodes":[
                            {"name":"entity_type","type":"string"},
                            {"name":"label","type":"string"},
                            {"name":"url","type":"string"},
                            {"name":"opacity","type":"number"},
                            {"name":"borderWidth","type":"number"},
                            {"name":"borderColor","type":"string"},
                            {"name":"size","type":"number"},
                            {"name":"selected","type":"boolean","defValue":false},
                            {"name":"color","type":"string"},
                            {"name":"shape","type":"string"},
                            {"name":"info","type":"object"}
                        ],
                        "edges":[
                            {"name":"database","type":"string"},
                            {"name":"info","type":"object"},
                            {"name":"opacity","type":"number"},
                            {"name":"color","type":"string"},
                            {"name":"width","type":"number"},
                            {"name":"weight","type":"number"}
                        ]},
        */
        /* nodes string example
        {"label":"MDM2","id":"MDM2"},
        {"label":"TP53","id":"TP53"},
        */
        /* edges string example
        {"source":"MDM2","target":"TP53","database":"undefined"},
        */
        switch ($entityType) {
            case "CompoundDict":
                $colorCentralNode="#f0f6a6";
                break;
            case "Cytochrome":
                $colorCentralNode="#ffcfcf";
                break;
        }
        //First of all we generate the complete dictionaryRelations. We already have the relations of the compound/cytochrome, but we need to add the relations of the rest of entities with the actual compounds of the interaction network. For that we do:
        //ld($dictionaryRelations);
        foreach($dictionaryRelations as $key => $value){
            //ld($key);
            if(($key=="terms") and (count($dictionaryRelations["terms"]) != 0)){
                $dictionaryTerms=$dictionaryRelations["terms"];
                foreach($dictionaryTerms as $term=>$count){
                    $arrayCompoundsFromTermReturned=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Term2Document')->findCompounds2Term2DocumentFromTerm($term,$dictionaryRelations["compounds"]); //We pass dictionaryRelations["compounds"] as an argument since we just want interactions with compounds that are already in the interaction network
                    //If the array has something (term2compounds) we update the $dictionaryRelations
                    $arrayCompoundsFromTerm=$arrayCompoundsFromTermReturned[0];
                    $arrayTypeRelationsTerm=$arrayCompoundsFromTermReturned[1];
                    if(count($arrayCompoundsFromTerm) != 0){
                        $dictionaryTermRelations[$term]=$arrayCompoundsFromTerm;
                        $dictionaryTermTypeRelations[$term]=$arrayTypeRelationsTerm;
                    }
                }
            }

            if(($key=="cyps") and (count($dictionaryRelations["cyps"]) != 0)) {
                $message="Inside CYPs";
                $dictionaryCyps=$dictionaryRelations["cyps"];
                foreach($dictionaryCyps as $cyp => $value){
                    $arrayCompoundsFromCypReturned=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Cyp2Document')->findCompounds2Cyp2DocumentFromCyp($cyp,$dictionaryRelations["compounds"]); //We pass dictionaryRelations["compounds"] as an argument since we just want interactions with compounds that are already in the interaction network
                    //If the array has something (cyp2compounds) we load the $dictionaryCypRelations
                    $arrayCompoundsFromCyp=$arrayCompoundsFromCypReturned[0];
                    $arrayTypeRelationsCyp=$arrayCompoundsFromCypReturned[1];
                    if(count($arrayCompoundsFromCyp) != 0){
                        $dictionaryCypRelations[$cyp]=$arrayCompoundsFromCyp;
                        $dictionaryCypTypeRelations[$cyp]=$arrayTypeRelationsCyp;
                    }
                }
            }
            if(($key=="markers") and (count($dictionaryRelations["markers"]) != 0)){
                $dictionaryMarkers=$dictionaryRelations["markers"];
                foreach($dictionaryMarkers as $marker => $weightMarker){
                    $arrayCompoundsFromMarkerReturned=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Marker2Document')->findCompounds2Marker2DocumentFromMarker($marker,$dictionaryRelations["compounds"]); //We pass dictionaryRelations["compounds"] as an argument since we just want interactions with compounds that are already in the interaction network
                    //If the array has something (marker2compounds) we load the $dictionaryMarkerRelations
                    $arrayCompoundsFromMarker=$arrayCompoundsFromMarkerReturned[0];
                    $arrayTypeRelationsMarker=$arrayCompoundsFromMarkerReturned[1];
                    if(count($arrayCompoundsFromMarker) != 0){
                        $dictionaryMarkerRelations[$marker]=$arrayCompoundsFromMarker;
                        $dictionaryMarkerTypeRelations[$marker]=$arrayTypeRelationsMarker;
                    }
                }
            }
            if(($key=="compounds") and (count($dictionaryRelations["compounds"]) != 0)){
                $dictionaryCompounds=$dictionaryRelations["compounds"];
                //ld($dictionaryCompounds);
                foreach($dictionaryCompounds as $compoundName => $weightCompound){
                    //ld($compoundName);
                    $compound=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromName($compoundName);
                    //ld($compound);
                    $idCompound=$compound->getId();
                    $arrayCompoundsFromCompoundId=$this->findCompounds2Compounds2FromCompound($idCompound,$dictionaryRelations["compounds"]); //We pass dictionaryRelations["compounds"] as an argument since we just want interactions with compounds that are already in the interaction network
                    //If the array has something (term2compounds) we update the $dictionaryRelations
                    if(count($arrayCompoundsFromCompoundId) != 0){
                        $dictionaryCompoundRelations[$compound->getName()]=$arrayCompoundsFromCompoundId;
                    }
                }
            }
        }
        //Here we have dictionaryRelations and rest of arrays with all the entity2entity interactions of the network. We just have to iterate over the arrays to draw the nodes and edges.
        //To draw the nodes we iterate over dictionaryRelations
        //First of all we generate the string for the main node.
        $stringNodes="{\"label\":\"$entityName\",\"id\":\"$entityName\",\"entity_type\":\"$entityType\",\"color\":\"$colorCentralNode\"},\n";
        //Then we generate the rest of the nodes as well as the edges linking the new nodes with the main one
        foreach($dictionaryRelations as $key => $value){
            if(($key=="compounds") and (count($dictionaryRelations["compounds"]) != 0)){
                $dictionaryCompounds=$dictionaryRelations["compounds"];
                //$dictionaryCompoundsNormalizedWeights=$this->normalizeWeights($dictionaryCompounds);
                foreach($dictionaryCompounds as $compound => $weightCompound){
                    $stringNodes.="{\"label\":\"$compound\",\"id\":\"$compound\",\"entity_type\":\"CompoundDict\",\"color\":\"#f0f6a6\"},\n";
                    //$arrayRGB=$this->percentToRGB($dictionaryCompoundsNormalizedWeights[$compound]);
                    $arrayRGB=$this->percentToRGB(100*$weightCompound); //$weightCompound comes already normalized
                    $colorHEX=$this->rgb2hex($arrayRGB);
                    //$infoEdge = "'weight': $weightCompound";
                    $weightCytoScape=$dictionaryRelations["compounds"][$compound];

                    $stringEdges.="{\"source\":\"$entityName\",\"target\":\"$compound\",\"database\":\"tanimotovalues\",\"weight\":$weightCytoScape,\"color\":\"$colorHEX\", \"opacity\":$weightCompound},\n";
                }
            }
            if(($key=="terms") and (count($dictionaryRelations["terms"]) != 0)){
                $message="terms";
                $dictionaryTerms=$dictionaryRelations["terms"];
                //$dictionaryTermsNormalizedWeights=$this->normalizeWeights($dictionaryTerms);
                foreach($dictionaryTerms as $term => $weightTerm){
                    $stringNodes.="{\"label\":\"$term\",\"id\":\"$term\",\"entity_type\":\"Term\",\"color\":\"#d597fb\"},\n";
                    //We normalize weightTerms between 0 and 1, just to paint edges but labels still $weightTerm
                    if($weightTerm==1){
                        $normalizedWeight=0.01;
                    }else{
                        $normalizedWeight=1-1/$weightTerm;
                    }
                    $arrayRGB=$this->percentToRGB(100*$normalizedWeight);
                    $colorHEX=$this->rgb2hex($arrayRGB);
                    $weightCytoScape=$dictionaryRelations["terms"][$term];
                    $arrayRelations=$dictionaryTypeRelations["terms"][$term];
                    $stringRelations="";
                    foreach($arrayRelations as $type=>$counter){
                        $stringRelations=$stringRelations." $type: $counter,";
                    }
                    $stringRelations=rtrim($stringRelations, ",");
                    $stringEdges.="{\"source\":\"$entityName\",\"target\":\"$term\",\"database\":\"compound2term2document_new\",\"weight\":$weightTerm,\"color\":\"$colorHEX\", \"opacity\":$normalizedWeight, \"typeOfRelations\": \"$stringRelations\"},\n";
                }
            }
            if(($key=="cyps") and (count($dictionaryRelations["cyps"]) != 0)) {
                $message="cyps";
                $dictionaryCyps=$dictionaryRelations["cyps"];
                //$dictionaryCypsNormalizedWeights=$this->normalizeWeights($dictionaryCyps);
                foreach($dictionaryCyps as $cyp => $weightCyp){
                    $stringNodes.="{\"label\":\"$cyp\",\"id\":\"$cyp\",\"entity_type\":\"Cytochrome\",\"color\":\"#ffcfcf\"},\n";
                    //$arrayRGB=$this->percentToRGB($dictionaryCypsNormalizedWeights[$cyp]);
                    if($weightCyp==1){
                        $normalizedWeight=0.01;
                    }else{
                        $normalizedWeight=1-1/$weightCyp;
                    }
                    $arrayRGB=$this->percentToRGB(100*$normalizedWeight);
                    $colorHEX=$this->rgb2hex($arrayRGB);
                    $weightCytoScape=$dictionaryRelations["cyps"][$cyp];
                    $arrayRelations=$dictionaryTypeRelations["cyps"][$cyp];
                    $stringRelations="";
                    foreach($arrayRelations as $type=>$counter){
                        $stringRelations=$stringRelations." $type: $counter,";
                    }
                    $stringRelations=rtrim($stringRelations, ",");
                    $stringEdges.="{\"source\":\"$entityName\",\"target\":\"$cyp\",\"database\":\"compound2cyp2document_new\",\"weight\":$weightCyp,\"color\":\"$colorHEX\", \"opacity\":$normalizedWeight, \"typeOfRelations\": \"$stringRelations\"},\n";
                }
            }
            if(($key=="markers") and (count($dictionaryRelations["markers"]) != 0)){
                $message="markers";
                $dictionaryMarkers=$dictionaryRelations["markers"];
                //$dictionaryMarkersNormalizedWeights=$this->normalizeWeights($dictionaryMarkers);
                foreach($dictionaryMarkers as $marker => $weightMarker){
                    $stringNodes.="{\"label\":\"$marker\",\"id\":\"$marker\",\"entity_type\":\"Marker\",\"color\":\"#dffcff\"},\n";
                    //$arrayRGB=$this->percentToRGB($dictionaryMarkersNormalizedWeights[$marker]);
                    if($weightMarker==1){
                        $normalizedWeight=0.01;
                    }else{
                        $normalizedWeight=1-1/$weightCyp;
                    }
                    $arrayRGB=$this->percentToRGB(100*$normalizedWeight);
                    $colorHEX=$this->rgb2hex($arrayRGB);
                    $weightCytoScape=$dictionaryRelations["markers"][$marker];
                    $arrayRelations=$dictionaryTypeRelations["markers"][$marker];
                    $stringRelations="";
                    foreach($arrayRelations as $type=>$counter){
                        $stringRelations=$stringRelations."$type: $counter,";
                    }
                    $stringRelations=rtrim($stringRelations, ",");
                    $stringEdges.="{\"source\":\"$entityName\",\"target\":\"$marker\",\"database\":\"compound2marker2document_new\",\"weight\":$weightMarker,\"color\":\"$colorHEX\", \"opacity\":$normalizedWeight, \"typeOfRelations\": \"$stringRelations\"},\n";
                }
            }
        }

        //To draw the edges we iterate over the rest of arrays
        //Starting with compound2compound relations
        foreach($dictionaryCompoundRelations as $compoundStart=>$arrayCompoundsEnd){
            foreach($arrayCompoundsEnd as $compoundEnd=>$weight){
                $arrayRGB=$this->percentToRGB($weight*100);
                $colorHEX=$this->rgb2hex($arrayRGB);
                $stringEdges.="{\"source\":\"$compoundStart\",\"target\":\"$compoundEnd\",\"database\":\"tanimotovalues\",\"weight\":$weight,\"color\":\"$colorHEX\", \"opacity\":$weight},\n";
            }

        }
        //Following with Compound2Term relations
        foreach($dictionaryTermRelations as $termStart=>$arrayCompoundsEnd){
            foreach($arrayCompoundsEnd as $compoundEnd=>$weight){
                if($weight==1){
                    $normalizedWeight=0.01;
                }else{
                    $normalizedWeight=1-1/$weight;
                }
            }
            $arrayRGB=$this->percentToRGB($normalizedWeight*100);
            $colorHEX=$this->rgb2hex($arrayRGB);
            $arrayRelations = $dictionaryTermTypeRelations[$termStart][$compoundEnd];
            $stringRelations="";
            if (count($arrayRelations!=0)){
                foreach($arrayRelations as $type=>$counter){
                    $stringRelations=$stringRelations." $type: $counter,";
                }
            }
            $stringRelations=rtrim($stringRelations, ",");
            $stringEdges.="{\"source\":\"$termStart\",\"target\":\"$compoundEnd\",\"database\":\"compound2term2document_new\",\"weight\":$weight,\"color\":\"$colorHEX\", \"opacity\":$normalizedWeight, \"typeOfRelations\": \"$stringRelations\"},\n";
        }

        //Following with Compound2Cyp relations
        foreach($dictionaryCypRelations as $cypStart=>$arrayCompoundsEnd){
            foreach($arrayCompoundsEnd as $compoundEnd=>$weight){
                if($weight==1){
                    $normalizedWeight=0.01;
                }else{
                    $normalizedWeight=1-1/$weight;
                }
            }
            $arrayRGB=$this->percentToRGB($normalizedWeight*100);
            $colorHEX=$this->rgb2hex($arrayRGB);
            $arrayRelations = $dictionaryCypTypeRelations[$cypStart][$compoundEnd];
            $stringRelations="";
            if (count($arrayRelations!=0)){
                foreach($arrayRelations as $type=>$counter){
                    $stringRelations=$stringRelations." $type: $counter,";
                }
            }
            $stringRelations=rtrim($stringRelations, ",");
            $stringEdges.="{\"source\":\"$cypStart\",\"target\":\"$compoundEnd\",\"database\":\"compound2cyp2document_new\",\"weight\":$weight,\"color\":\"$colorHEX\", \"opacity\":$normalizedWeight, \"typeOfRelations\": \"$stringRelations\"},\n";
        }

        //Following with Compound2Marker relations
        foreach($dictionaryMarkerRelations as $markerStart=>$arrayCompoundsEnd){
            foreach($arrayCompoundsEnd as $compoundEnd=>$weight){
                if($weight==1){
                    $normalizedWeight=0.01;
                }else{
                    $normalizedWeight=1-1/$weight;
                }
            }
            $arrayRGB=$this->percentToRGB($normalizedWeight*100);
            $colorHEX=$this->rgb2hex($arrayRGB);
            $arrayRelations = $dictionaryMarkerTypeRelations[$markerStart][$compoundEnd];
            $stringRelations="";
            if (count($arrayRelations!=0)){
                foreach($arrayRelations as $type=>$counter){
                    $stringRelations=$stringRelations." $type: $counter,";
                }
            }
            $stringRelations=rtrim($stringRelations, ",");
            $stringEdges.="{\"source\":\"$markerStart\",\"target\":\"$compoundEnd\",\"database\":\"compound2marker2document_new\",\"weight\":$weight,\"color\":\"$colorHEX\", \"opacity\":$normalizedWeight, \"typeOfRelations\": \"$stringRelations\"},\n";
        }


        $arrayStrings=array();
        $arrayStrings["stringNodes"]=$stringNodes;
        $arrayStrings["stringEdges"]=$stringEdges;
        return $arrayStrings;
    }
}
