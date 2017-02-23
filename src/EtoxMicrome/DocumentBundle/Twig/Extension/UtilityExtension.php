<?php

namespace EtoxMicrome\DocumentBundle\Twig\Extension;

use Symfony\Bridge\Doctrine\RegistryInterface;
use EtoxMicrome\Entity2DocumentBundle\Entity\Entity2Document;
use EtoxMicrome\DocumentBundle\Entity\DocumentWithCompound;
use Twig_Extension;
use Twig_Filter_Method;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UtilityExtension extends \Twig_Extension
{
    protected $doctrine;
    protected $generator;

    public function __construct(RegistryInterface $doctrine, UrlGeneratorInterface $generator)
    {
        $this->doctrine = $doctrine;
        $this->generator = $generator;
    }

    public function getFilters()
    {
        return array(
        'highlightEntitiesDocuments' => new \Twig_Filter_Method($this, 'highlightEntitiesDocuments'),
        'highlightEntitiesDocumentsKeywords' => new \Twig_Filter_Method($this, 'highlightEntitiesDocumentsKeywords'),
        'highlightEntitiesAbstracts' => new \Twig_Filter_Method($this, 'highlightEntitiesAbstracts'),
        'highlightGenesAbstracts' => new \Twig_Filter_Method($this, 'highlightGenesAbstracts'),
        'highlightKeywordText' => new \Twig_Filter_Method($this, 'highlightKeywordText'),
        'colorCodingScore' => new \Twig_Filter_Method($this, 'colorCodingScore'),
        'setCurationHtml' => new \Twig_Filter_Method($this, 'setCurationHtml'),
        'highlightRelations' => new \Twig_Filter_Method($this, 'highlightRelations'),
        'getScoreToShow' => new \Twig_Filter_Method($this, 'getScoreToShow'),
        'getScoreToShowRelations' => new \Twig_Filter_Method($this, 'getScoreToShowRelations'),
        'getOrderToSource' => new \Twig_Filter_Method($this, 'getOrderToSource'),

        );
    }

    function name_length_sort($a, $b)
    {
        //Callback function to use with uasort to sort descend an array of Gene2Abstracts by its geneName length
        if ( strlen($a->getGeneName()) < strlen($b->getGeneName()) ) return 1;
        if ( strlen($a->getGeneName()) > strlen($b->getGeneName()) ) return -1;
        return 0;
    }

    function name_length_sort_termVariant($a, $b)
    {
        //Callback function to use with uasort to sort descend an array of Gene2Abstracts by its geneName length
        if ( strlen($a->getTermVariant()) < strlen($b->getTermVariant()) ) return 1;
        if ( strlen($a->getTermVariant()) > strlen($b->getTermVariant()) ) return -1;
        return 0;
    }

    function name_length_sort_cypsMention($a, $b)
    {
        //Callback function to use with uasort to sort descend an array of Gene2Abstracts by its geneName length
        if ( strlen($a->getCypsMention()) < strlen($b->getCypsMention()) ) return 1;
        if ( strlen($a->getCypsMention()) > strlen($b->getCypsMention()) ) return -1;
        return 0;
    }

    function name_length_sort_hepKeywordNorm($a, $b)
    {
        //Callback function to use with uasort to sort descend an array of Gene2Abstracts by its geneName length
        if ( strlen($a->getHepKeywordNorm()) < strlen($b->getHepKeywordNorm()) ) return 1;
        if ( strlen($a->getHepKeywordNorm()) > strlen($b->getHepKeywordNorm()) ) return -1;
        return 0;
    }

    function name_length_sort_name($a, $b)
    {
        //Callback function to use with uasort to sort descend an array of Gene2Abstracts by its geneName length
        if ( strlen($a->getName()) < strlen($b->getName()) ) return 1;
        if ( strlen($a->getName()) > strlen($b->getName()) ) return -1;
        return 0;
    }

    function name_length_sort_specie($a, $b)
    {
        //Callback function to use with uasort to sort descend an array of Gene2Abstracts by its geneName length
        if ( strlen($a->getSpecie()->getName()) < strlen($b->getSpecie()->getName()) ) return 1;
        if ( strlen($a->getSpecie()->getName()) > strlen($b->getSpecie()->getName()) ) return -1;
        return 0;
    }

    public function findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted)
    {
        //Returns an array with the valid position/s to make the highlight or a void array if there is no position...
        $arrayPositions=array();
        //ld($arrayText);
        $foundPlace=false;//We use this variable to switch finding method to include complex words and more
        foreach($arrayText as $i => $word){
            if(strpos($word, $entityName) !== false){
                if (in_array($i, $arrayHighlighted)){
                    //do nothing
                }else{
                    array_push($arrayPositions, $i);
                }
            }
        }
        return $arrayPositions;
    }

    public function findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted)
    {
        //Returns an array with the starting valid positions to start the highlight
        $arrayEntityNames=str_word_count($entityName, 1, '0..9()=-.');
        $numberOfEntityNames=count($arrayEntityNames);
        $arrayStartingPlaces=$this->findPlaceSingleWord($arrayEntityNames[0],$arrayText,$arrayHighlighted);
        //Here we have an array with the posible starting places... Once we get one, by now, we dont want anymore.
        //We search for a starting place with the same first content as the first place of arrayEntityNames
        //Then we extend the comparisson until the last place returning the isConsecutive boolean
        $isConsecutive=true;
        foreach($arrayStartingPlaces as $startingPlace){
            $counter=0;
            for($i=$startingPlace;($i<$startingPlace+$numberOfEntityNames) and ($i<count($arrayText)) ;$i++){
                //ld($arrayText[$i]);
                //ld($arrayEntityNames[$counter]);
                if(strcasecmp($arrayText[$i], $arrayEntityNames[$counter])==0){
                    if (in_array($i, $arrayHighlighted)){
                    }else{
                        $isConsecutive=true;
                    }
                }else{
                    $isConsecutive=false;
                }
                $counter=$counter+1;
            }
            if($isConsecutive==true){
                return $startingPlace;
            }
        }
        //If it arrives here there's no startingPlace that fits the starting premises, so we return a -1 value, indicating that a startingPlace has not been found
        return (-1);

        ldd($message);

    }

    public function highlightEntitiesDocumentsKeywords($text,$sentenceId,$entityBackup, $field, $whatToSearch, $source, $entityType, $tooltipCounter)
    {
        $message="Inside of highlightEntitiesDocumentsKeywords";
        $em=$this->doctrine->getManager();
        $document=$em->getRepository('EtoxMicromeDocumentBundle:Document')->getDocumentFromSentenceId($sentenceId);
        $arrayReturn=$this->highlightEntitiesDocuments($text,$document,$entityBackup, $field, $whatToSearch, $source, $entityType, $tooltipCounter);
        return $arrayReturn;
    }

    public function highlightEntitiesDocuments($text,$document,$entityBackup, $field, $whatToSearch, $source, $entityType, $tooltipCounter)
    {
        //This function should return an array with both, $array[0] = the text highlighted, $array[1] = the html for the divs containing the sticky tooltips and $array[2] = the tooltipCounter number
        //the parameters $field, $whatToSearch, $entityType are used to create the url to link the entities for searching themselves
        $message="highlightEntitiesDocuments!!!";

        $em=$this->doctrine->getManager();
        //We need all the entities involved in the same document
        $mouseoverDivs="";

        //Sometimes $document is not a Document but a DocumentWithCompound or DocumentWithCytochrome etc...
        $className=$document->getClassName();
        //ld($className);
        if($className=="Document"){
            //We do nothing, in this case $document is already a Document
        }elseif($className=="DocumentWithCompound" or $className=="DocumentWithCytochrome" or $className=="DocumentWithMarker"){
            $document = $em->getRepository('EtoxMicromeDocumentBundle:Document')->getDocumentFromDocumentWith($document);
            $document = $document[0];
        }
        /*
        Here starts the algorithm.
            What we do is create an array from the text and keep track of the positions of this array that have been already hihglighted (using arrayHightlighted) because
            this positions won't be able to be highlighted again.
            It well behave in a different way if the entityName is made of one word o several words!!
                -If entityName is one word only. We change its content inside the array and add the position of the array in arrayHighlighted
                -If entityName is two or more words. We start an iterative process to guess its real position and once it's found, whe highlight
                the firs and last positions keeping track of all of them inside arrayHighligthed

        */
        $arrayText=str_word_count($text, 1, '0..9()=-');
        $arrayHighlighted=array();
        //With arrayHepKeywordTermVariant2Document we can highlight Hepatotoxicity Terms
        $arrayHepKeywordTermVariant2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:HepKeywordTermVariant2Document')->findHepKeywordTermVariant2Document($document);
        //Next two lines are done to avoid repeated elements and start highlighting from the longest term to the shortest (to avoid "short-tagging")
        $arrayHepKeywordTermVariant2Document=array_unique($arrayHepKeywordTermVariant2Document);
        uasort($arrayHepKeywordTermVariant2Document,array($this, 'name_length_sort_termVariant'));
        foreach ($arrayHepKeywordTermVariant2Document as $term2Document){
            $entityName=$term2Document->getTermVariant();
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            $term2DocumentId=$term2Document->getId();
            if (strcasecmp($entityName, $entityBackup) != 0) {
                $numberWords=str_word_count($entityName, 0, '0..9()=-');
                if($numberWords==1){
                    //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                    //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                    foreach($arrayPlaces as $place){
                        array_push($arrayHighlighted, $place);
                        $text=$arrayText[$place];
                        $text = str_ireplace($entityName, '<mark class="term">'.$entityName.'</mark>', $text);
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermVariant");
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\"  class=\"atip\">$mouseoverSummary</div>";
                        //We generate the route to a free search with the entityName.
                        $link=$this->generator->generate('elasticSearch_keyword', array('whatToSearch' => 'any', 'source' => $source, 'keyword' => $entityName,));
                        $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$entityName."</a></span>", $text);
                        $tooltipCounter=$tooltipCounter+1;
                        $arrayText[$place]=$text;
                        array_push($arrayHighlighted, $place);
                    }

                }else{
                    //This is when the entityName is made by more than one word
                    //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0); We have to take into account that the place cannot be at the end if the end of the entityName is falling outside the array...
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error
                            $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                            //We mark the first
                            $text=$arrayText[$place];
                            $text = str_ireplace($arrayEntityName[0], '<mark class="term">'.$arrayEntityName[0], $text);
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermVariant");
                            $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                            //We generate the route to a free search with the entityName.
                            $link=$this->generator->generate('elasticSearch_keyword', array('whatToSearch' => 'any', 'source' => $source, 'keyword' => $entityName,));
                            $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$arrayEntityName[0], $text);
                            $tooltipCounter=$tooltipCounter+1;
                            $arrayText[$place]=$text;
                            //Mark the last
                            $text=$arrayText[$place+$numberEntityName-1];
                            $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                            $arrayText[$place+$numberEntityName-1]=$text;
                            //Add all range to arrayHighlighted
                            foreach(range($place,$place+$numberEntityName-1) as $i){
                                array_push($arrayHighlighted, $i);
                            }
                        }

                    }

                }
            }else{
                //We haven't changed color for entityBackup case insensitive search of entities. We change it now.
                //$text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                $numberWords=str_word_count($entityName, 0, '0..9()=-');
                if($numberWords==1){
                    $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                    foreach($arrayPlaces as $place){
                        array_push($arrayHighlighted, $place);
                        $text=$arrayText[$place];
                        $text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                        if($entityType=="HepKeywordTermVariant"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermVariant");
                        }elseif($entityType=="HepKeywordTermNorm"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");
                        }elseif($entityType=="HepatotoxKeyword"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepatotoxKeyword");
                        }elseif($entityType=="keyword"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermVariant");
                        }
                        $link=$this->generator->generate('elasticSearch_keyword', array('whatToSearch' => 'any', 'source' => $source, 'keyword' => $entityBackup,));
                        $text = str_ireplace($entityBackup, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$entityBackup."</a></span>", $text);
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                        $tooltipCounter=$tooltipCounter+1;
                        $arrayText[$place]=$text;
                        array_push($arrayHighlighted, $place);
                    }
                }else{
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error
                            $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                            //We mark the first
                            $text=$arrayText[$place];
                            if($entityType=="HepKeywordTermVariant"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermVariant");
                            }elseif($entityType=="HepKeywordTermNorm"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");
                            }elseif($entityType=="HepatotoxKeyword"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepatotoxKeyword");
                            }
                            $link=$this->generator->generate('elasticSearch_keyword', array('whatToSearch' => 'any', 'source' => $source, 'keyword' => $entityBackup,));
                            $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$arrayEntityName[0], $text);
                            $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                            $tooltipCounter=$tooltipCounter+1;
                            $arrayText[$place]=$text;
                            //Mark the last
                            $text=$arrayText[$place+$numberEntityName-1];
                            $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                            $arrayText[$place+$numberEntityName-1]=$text;
                            //Add all range to arrayHighlighted
                            foreach(range($place,$place+$numberEntityName-1) as $i){
                                array_push($arrayHighlighted, $i);
                            }
                        }
                    }
                }
            }
        }
        //With arrayCytochrome2Document we can highlight Cytochromes
        $arrayCytochrome2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Cytochrome2Document')->findCytochrome2DocumentFromDocument($document);
        //Next two lines are done to avoid repeated elements and start highlighting from the longest term to the shortest (to avoid "short-tagging")
        $arrayCytochrome2Document=array_unique($arrayCytochrome2Document);
        uasort($arrayCytochrome2Document,array($this, 'name_length_sort_cypsMention'));

        foreach ($arrayCytochrome2Document as $cytochrome2Document){
            $entityName=$cytochrome2Document->getCypsMention();
            //ld($entityName);
            $cytochrome2DocumentId=$cytochrome2Document->getId();
            //ld($entityBackup);
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            if (strcasecmp($entityName, $entityBackup) != 0) {
                $numberWords=str_word_count($entityName, 0, '0..9()=-');
                if($numberWords==1){
                    //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                    //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                    foreach($arrayPlaces as $place){
                        array_push($arrayHighlighted, $place);
                        $text=$arrayText[$place];
                        $text = str_ireplace($entityName, '<mark class="cytochrome">'.$entityName.'</mark>', $text);
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($cytochrome2DocumentId,"Cytochrome");
                        $entityNameUrlEncoded=urlencode($entityName);
                        $link=$this->generator->generate('search_interface_search_field_whatToSearch_entityType_source_entity', array('field' => $field, 'whatToSearch' => $whatToSearch, 'entityType' => 'cytochrome', 'source' => $source, 'entityName' => $entityNameUrlEncoded,));
                        $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$entityName."</a></span>", $text);
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                        $tooltipCounter=$tooltipCounter+1;
                        $arrayText[$place]=$text;
                    }
                }else{
                    //This is when the entityName is made by more than one word
                    //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error
                            $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                            //We mark the first
                            $text=$arrayText[$place];
                            $text = str_ireplace($arrayEntityName[0], '<mark class="cytochrome">'.$arrayEntityName[0], $text);
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($cytochrome2DocumentId,"Cytochrome");
                            $entityNameUrlEncoded=urlencode($entityName);
                            $link=$this->generator->generate('search_interface_search_field_whatToSearch_entityType_source_entity', array('field' => $field, 'whatToSearch' => $whatToSearch, 'entityType' => 'cytochrome', 'source' => $source, 'entityName' => $entityNameUrlEncoded, ));
                            $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$arrayEntityName[0], $text);
                            $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                            $tooltipCounter=$tooltipCounter+1;
                            $arrayText[$place]=$text;
                            //Mark the last
                            $text=$arrayText[$place+$numberEntityName-1];
                            $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                            $arrayText[$place+$numberEntityName-1]=$text;
                            //Add all range to arrayHighlighted
                            foreach(range($place,$place+$numberEntityName-1) as $i){
                                array_push($arrayHighlighted, $i);
                            }
                        }
                    }
                }
            }else{
                //We haven't changed color for entityBackup case insensitive search of entities. We change it now.
                //$text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                $message="entra aqui";
                $numberWords=str_word_count($entityName, 0, '0..9()=-');
                if($numberWords==1){
                    $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                    foreach($arrayPlaces as $place){
                        array_push($arrayHighlighted, $place);
                        $text=$arrayText[$place];
                        $text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($cytochrome2DocumentId,"Cytochrome");
                        $entityNameUrlEncoded=urlencode($entityName);
                        $link=$this->generator->generate('search_interface_search_field_whatToSearch_entityType_source_entity', array('field' => $field, 'whatToSearch' => $whatToSearch, 'entityType' => 'cytochrome', 'source' => $source, 'entityName' => $entityNameUrlEncoded, ));
                        $text = str_ireplace($entityBackup, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$entityBackup."</a></span>", $text);
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                        $tooltipCounter=$tooltipCounter+1;
                        $arrayText[$place]=$text;
                    }
                }else{
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error
                            $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                            //We mark the first
                            $text=$arrayText[$place];
                            $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($cytochrome2DocumentId,"Cytochrome");
                            $entityNameUrlEncoded=urlencode($entityName);
                            $link=$this->generator->generate('search_interface_search_field_whatToSearch_entityType_source_entity', array('field' => $field, 'whatToSearch' => $whatToSearch, 'entityType' => 'cytochrome', 'source' => $source, 'entityName' => $entityNameUrlEncoded, ));
                            $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$arrayEntityName[0], $text);
                            $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                            $tooltipCounter=$tooltipCounter+1;
                            $arrayText[$place]=$text;
                            //Mark the last
                            $text=$arrayText[$place+$numberEntityName-1];
                            $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                            $arrayText[$place+$numberEntityName-1]=$text;
                            //Add all range to arrayHighlighted
                            foreach(range($place,$place+$numberEntityName-1) as $i){
                                array_push($arrayHighlighted, $i);
                            }
                        }
                    }
                }
            }
        }
        //With arrayHepKeywordTermNorm2Document we can highlight Hepatotoxicity Terms
        $arrayHepKeywordTermNorm2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:HepKeywordTermNorm2Document')->findHepKeywordTermNorm2Document($document);
        //Next two lines are done to avoid repeated elements and start highlighting from the longest term to the shortest (to avoid "short-tagging")
        $arrayHepKeywordTermNorm2Document=array_unique($arrayHepKeywordTermNorm2Document);
        uasort($arrayHepKeywordTermNorm2Document,array($this, 'name_length_sort_hepKeywordNorm'));

        foreach ($arrayHepKeywordTermNorm2Document as $term2Document){
            $entityName=$term2Document->getHepKeywordNorm();
            //ld($entityName);
            $term2DocumentId=$term2Document->getId();
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            if (strcasecmp($entityName, $entityBackup) != 0) {
                $numberWords=str_word_count($entityName, 0, '0..9()=-');
                //ld($numberWords);
                if($numberWords==1){
                    //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                    //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                    foreach($arrayPlaces as $place){
                        array_push($arrayHighlighted, $place);
                        $text=$arrayText[$place];
                        $text = str_ireplace($entityName, '<mark class="term">'.$entityName.'</mark>', $text);
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");
                        //We generate the route to a free search with the entityName.
                        $link=$this->generator->generate('elasticSearch_keyword', array('whatToSearch' => $whatToSearch, 'source' => $source, 'keyword' => $entityName, ));
                        $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$entityName."</a></span>", $text);
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                        $tooltipCounter=$tooltipCounter+1;
                        $arrayText[$place]=$text;
                    }

                }else{
                    //This is when the entityName is made by more than one word
                    //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                            $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                            //We mark the first
                            $text=$arrayText[$place];
                            $text = str_ireplace($arrayEntityName[0], '<mark class="term">'.$arrayEntityName[0], $text);
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");
                            //We generate the route to a free search with the entityName.
                            $link=$this->generator->generate('elasticSearch_keyword', array('whatToSearch' => $whatToSearch, 'source' => $source, 'keyword' => $entityName, ));
                            $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$arrayEntityName[0], $text);
                            $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                            $tooltipCounter=$tooltipCounter+1;
                            $arrayText[$place]=$text;
                            //Mark the last
                            $text=$arrayText[$place+$numberEntityName-1];
                            $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                            $arrayText[$place+$numberEntityName-1]=$text;
                            //Add all range to arrayHighlighted
                            foreach(range($place,$place+$numberEntityName-1) as $i){
                                array_push($arrayHighlighted, $i);
                            }
                        }

                    }
                }
                $text = str_ireplace($entityName, '<mark class="term">'.$entityName.'</mark>', $text);
                //$mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");

                //$text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityName."</span>", $text);
            }else{
                //We haven't changed color for entityBackup case insensitive search of entities. We change it now.
                //$text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                $numberWords=str_word_count($entityName, 0, '0..9()=-');
                if($numberWords==1){
                    $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                    foreach($arrayPlaces as $place){
                        array_push($arrayHighlighted, $place);
                        $text=$arrayText[$place];
                        $text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                        if($entityType=="HepKeywordTermVariant"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermVariant");
                        }elseif($entityType=="HepKeywordTermNorm"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");
                        }elseif($entityType=="HepatotoxKeyword"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepatotoxKeyword");
                        }
                        $link=$this->generator->generate('elasticSearch_keyword', array('whatToSearch' => $whatToSearch, 'source' => $source, 'keyword' => $entityName, ));
                        $text = str_ireplace($entityBackup, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$entityBackup."</a></span>", $text);
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                        $tooltipCounter=$tooltipCounter+1;
                        $arrayText[$place]=$text;
                    }
                }else{
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                            $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                            //We mark the first
                            $text=$arrayText[$place];
                            ld($entityType);
                            if($entityType=="HepKeywordTermVariant"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermVariant");
                            }elseif($entityType=="HepKeywordTermNorm"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");
                            }elseif($entityType=="HepatotoxKeyword"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepatotoxKeyword");
                            }
                            $link=$this->generator->generate('elasticSearch_keyword', array('whatToSearch' => $whatToSearch, 'source' => $source, 'keyword' => $entityName, ));
                            $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$link\">".$arrayEntityName[0], $text);
                            $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\" >$mouseoverSummary</div>";
                            $tooltipCounter=$tooltipCounter+1;
                            $arrayText[$place]=$text;
                            //Mark the last
                            $text=$arrayText[$place+$numberEntityName-1];
                            $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                            $arrayText[$place+$numberEntityName-1]=$text;
                            //Add all range to arrayHighlighted
                            foreach(range($place,$place+$numberEntityName-1) as $i){
                                array_push($arrayHighlighted, $i);
                            }
                        }
                    }
                }
            }
            //We also add a link around the Term in order to search co-mentioned terms
        }

        //With arrayEntity2Document we can highlight CompoundDict, Marker and Specie
        $arrayEntity2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->findEntity2DocumentFromDocument($document);

        //Next two lines are done to avoid repeated elements and start highlighting from the longest term to the shortest (to avoid "short-tagging")
        $arrayEntity2Document=array_unique($arrayEntity2Document);
        uasort($arrayEntity2Document,array($this, 'name_length_sort_name'));

        foreach ($arrayEntity2Document as $entity2Document){
            $entityName=$entity2Document->getName();
            $entityNameUrlEncoded=urlencode($entityName);
            $qualifier=$entity2Document->getQualifier();
            $entity2DocumentId=$entity2Document->getId();
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            if (strcasecmp($entityName, $entityBackup) != 0) {
                //sustituimos en el text
                $message="EntityName==entityBackup";
                //ld($entityName);
                switch ($qualifier) {
                    case 'Marker':
                        $numberWords=str_word_count($entityName, 0, '0..9()=-');
                        //ld($numberWords);
                        if($numberWords==1){
                            //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                            //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                            foreach($arrayPlaces as $place){
                                array_push($arrayHighlighted, $place);
                                $text=$arrayText[$place];
                                $text = str_ireplace($entityName, '<mark class="marker">'.$entityName.'</mark>', $text);
                                $entityNameUrlEncoded=urlencode($entityName);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "marker",
                                        'source' => $source,
                                        'entityName' => $entityNameUrlEncoded,
                                    )
                                );
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId, "Marker");
                                $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$entityName."</a></span>", $text);
                                $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                                $tooltipCounter=$tooltipCounter+1;
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                                    $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                    //We mark the first
                                    $text=$arrayText[$place];
                                    $entityNameUrlEncoded=urlencode($entityName);
                                    $url = $this->generator->generate(
                                        'search_interface_search_field_whatToSearch_entityType_source_entity',
                                        array(
                                            'field' => $field,
                                            'whatToSearch' => $whatToSearch,
                                            'entityType' => "marker",
                                            'source' => $source,
                                            'entityName' => $entityNameUrlEncoded,
                                        )
                                    );
                                    $text = str_ireplace($arrayEntityName[0], '<mark class="marker">'.$arrayEntityName[0], $text);
                                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"Marker");
                                    $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$arrayEntityName[0], $text);
                                    $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                                    $tooltipCounter=$tooltipCounter+1;
                                    $arrayText[$place]=$text;
                                    //Mark the last
                                    $text=$arrayText[$place+$numberEntityName-1];
                                    $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                                    $arrayText[$place+$numberEntityName-1]=$text;
                                    //Add all range to arrayHighlighted
                                    foreach(range($place,$place+$numberEntityName-1) as $i){
                                        array_push($arrayHighlighted, $i);
                                    }
                                }
                            }

                        }
                        //ld($text);
                        break;
                    case 'Specie':
                        $alert="entra en Specie";
                        $numberWords=str_word_count($entityName, 0, '0..9()=-');
                        //ld($alert);
                        if($numberWords==1){
                            //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                            //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                            foreach($arrayPlaces as $place){
                                array_push($arrayHighlighted, $place);
                                $text=$arrayText[$place];
                                $text = str_ireplace($entityName, '<mark class="specie">'.$entityName.'</mark>', $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId, "Specie");
                                $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\">".$entityName."</span>", $text);
                                $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                                $tooltipCounter=$tooltipCounter+1;
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                                    $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                    //We mark the first
                                    $text=$arrayText[$place];
                                    $text = str_ireplace($arrayEntityName[0], '<mark class="specie">'.$arrayEntityName[0], $text);
                                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"Specie");
                                    $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\">".$arrayEntityName[0], $text);
                                    $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                                    $tooltipCounter=$tooltipCounter+1;
                                    $arrayText[$place]=$text;
                                    //Mark the last
                                    $text=$arrayText[$place+$numberEntityName-1];
                                    $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</span></mark>", $text);
                                    $arrayText[$place+$numberEntityName-1]=$text;
                                    //Add all range to arrayHighlighted
                                    foreach(range($place,$place+$numberEntityName-1) as $i){
                                        array_push($arrayHighlighted, $i);
                                    }
                                }
                            }
                        }
                        //ld($text);
                        break;
                    case 'CompoundDict':
                        $alert="entra en CompoundDict";
                        $numberWords=str_word_count($entityName, 0, '0..9()=-');
                        if($numberWords==1){
                            //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                            //ld($arrayPlaces);
                            //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                            foreach($arrayPlaces as $place){
                                array_push($arrayHighlighted, $place);
                                $text=$arrayText[$place];
                                $text = str_ireplace($entityName, '<mark class="compound">'.$entityName.'</mark>', $text);
                                $entityNameUrlEncoded=urlencode($entityName);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => 'compoundDict',
                                        'source' => $source,
                                        'entityName' => $entityNameUrlEncoded,
                                    )
                                );
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId, "CompoundDict");
                                $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$entityName."</a></span>", $text);
                                $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                                $tooltipCounter=$tooltipCounter+1;
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $entityNameUrlEncoded=urlencode($entityName);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => 'compoundDict',
                                        'source' => $source,
                                        'entityName' => $entityNameUrlEncoded,
                                    )
                                );
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                                    $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                    //We mark the first
                                    $text=$arrayText[$place];
                                    $text = str_ireplace($arrayEntityName[0], '<mark class="compound">'.$arrayEntityName[0], $text);
                                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"CompoundDict");
                                    $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$arrayEntityName[0], $text);
                                    $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                                    $tooltipCounter=$tooltipCounter+1;
                                    $arrayText[$place]=$text;
                                    //Mark the last
                                    $text=$arrayText[$place+$numberEntityName-1];
                                    $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                                    $arrayText[$place+$numberEntityName-1]=$text;
                                    //Add all range to arrayHighlighted
                                    foreach(range($place,$place+$numberEntityName-1) as $i){
                                        array_push($arrayHighlighted, $i);
                                    }
                                }
                            }
                        }
                        //ld($text);
                        break;
                }
            }else{
                //$message="We haven't changed color for entityBackup case insensitive search of entities. We change it now.";
                //$text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                $numberWords=str_word_count($entityName, 0, '0..9()=-');
                //ld($arrayText);
                if($numberWords==1){
                    $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                    //ld($arrayPlaces);
                    foreach($arrayPlaces as $place){
                        array_push($arrayHighlighted, $place);
                        $text=$arrayText[$place];
                        $text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                        if ($entityType=="CompoundDict" or $entityType=="keyword"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId, "CompoundDict");
                        }elseif($entityType=="Marker"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId, "Marker");
                        }elseif($entityType=="Specie"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"Specie");
                        }
                        $entityNameUrlEncoded=urlencode($entityBackup);
                        $url = $this->generator->generate(
                            'search_interface_search_field_whatToSearch_entityType_source_entity',
                            array(
                                'field' => $field,
                                'whatToSearch' => $whatToSearch,
                                'entityType' => "compoundDict",
                                'source' => $source,
                                'entityName' => $entityNameUrlEncoded,
                            )
                        );
                        $text = str_ireplace($entityBackup, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$entityBackup."</a></span>", $text);
                        $arrayText[$place]=$text;
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";

                        $tooltipCounter=$tooltipCounter+1;

                    }
                }else{
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                            $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                            //We mark the first
                            $text=$arrayText[$place];
                            if($entityType=="CompoundDict" or $entityType=="keyword"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"CompoundDict");
                            }elseif($entityType=="Marker"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"Marker");
                            }elseif($entityType=="Specie"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"Specie");
                            }
                            $entityNameUrlEncoded=urlencode($entityBackup);
                            $url = $this->generator->generate(
                                'search_interface_search_field_whatToSearch_entityType_source_entity',
                                array(
                                    'field' => $field,
                                    'whatToSearch' => $whatToSearch,
                                    'entityType' => "compoundDict",
                                    'source' => $source,
                                    'entityName' => $entityNameUrlEncoded,
                                )
                            );
                            $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$arrayEntityName[0], $text);
                            $arrayText[$place]=$text;
                            $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                            $tooltipCounter=$tooltipCounter+1;
                            //Mark the last
                            $text=$arrayText[$place+$numberEntityName-1];
                            $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                            $arrayText[$place+$numberEntityName-1]=$text;
                            //Add all range to arrayHighlighted
                            foreach(range($place,$place+$numberEntityName-1) as $i){
                                array_push($arrayHighlighted, $i);
                            }
                        }
                    }
                }
            }
        }

        //Now we search for species to highlight directly from specie2document using the document_id";
        //With arraySpecie2Document we can highlight Species inside the text
        $arraySpecie2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Specie2Document')->findSpecie2DocumentFromDocument($document);
        //Next two lines are done to avoid repeated elements and start highlighting from the longest term to the shortest (to avoid "short-tagging")
        $arraySpecie2Document=array_unique($arraySpecie2Document);
        uasort($arraySpecie2Document,array($this, 'name_length_sort_specie'));

        foreach($arraySpecie2Document as $specie2document){
            $specieName=$specie2document->getSpecie()->getName();
            $numberWords=str_word_count($specieName, 0, '0..9()=-');
            if($numberWords==1){
                $arrayPlaces=$this->findPlaceSingleWord($specieName,$arrayText,$arrayHighlighted);
                foreach($arrayPlaces as $place){
                    array_push($arrayHighlighted, $place);
                    $text=$arrayText[$place];
                    $text = str_ireplace($specieName, '<mark class="specie">'.$specieName.'</mark>', $text);
                    $text = str_ireplace($specieName, "<span data-tooltip=\"sticky$tooltipCounter\">".$specieName."</span>", $text);
                    $arrayText[$place]=$text;
                    $mouseoverSummary="Add mouseoversummary at utilityExtension:802";
                    $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                    $tooltipCounter=$tooltipCounter+1;
                }
            }else{
                $place=$this->findPlaceSeveralWords($specieName,$arrayText,$arrayHighlighted);
                if($place!=-1){
                    //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                    $numberSpecieName=str_word_count($specieName, 0, '0..9()=-');
                    if($place+$numberSpecieName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                        $arraySpecieName=str_word_count($specieName, 1, '0..9()=-');
                        //We mark the first
                        $text=$arrayText[$place];
                        $text = str_ireplace($arraySpecieName[0], '<mark class="specie">'.$arraySpecieName[0], $text);
                        $mouseoverSummary="Add mouseoversummary at utilityExtension:815";
                        $text = str_ireplace($arraySpecieName[0], "<span data-tooltip=\"sticky$tooltipCounter\">".$arrayEntityName[0], $text);
                        $arrayText[$place]=$text;
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                        $tooltipCounter=$tooltipCounter+1;
                        //Mark the last
                        $text=$arrayText[$place+$numberSpecieName-1];
                        $text = str_ireplace($arraySpecieName[$numberSpecieName-1], $arraySpecieName[$numberSpecieName-1]."</span></mark>", $text);
                        $arrayText[$place+$numberSpecieName-1]=$text;
                        //Add all range to arrayHighlighted
                        foreach(range($place,$place+$numberSpecieName-1) as $i){
                            array_push($arrayHighlighted, $i);
                        }
                    }
                }
            }
        }
        $text=implode(" ", $arrayText);
        //$text=str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>' , $text);
        $arrayReturn=array();
        $arrayReturn[0]=$text;
        $arrayReturn[1]=$mouseoverDivs;
        $arrayReturn[2]=$tooltipCounter;
        return ($arrayReturn);
    }

    public function highlightEntitiesAbstracts($text,$abstract,$entityBackup,$field, $whatToSearch, $source, $entityType, $tooltipCounter)
    {
        $message="highlightEntitiesAbstracts!!!";
        $mouseoverDivs="";
        //ld($text);
        //ld($entityBackup);
        $em=$this->doctrine->getManager();
        //We need all the entities involved in the same document
        //Tweak to use this method with both abstracts and result objects from elasticsearch results
        if($abstract instanceof \EtoxMicrome\DocumentBundle\Entity\Abstracts){
            $className=$abstract->getClassName();
        }else{
            $className=$abstract->getType();
        }
        //ldd($className);
        if($className=="abstracts"){
            //We do nothing, in this case $abstract is already a Abstracts
        }elseif($className=="abstractswithcompounds"){
            $arrayAbstract=$abstract->getSource();
            $pmid=$arrayAbstract['pmid'];
            $abstract = $em->getRepository('EtoxMicromeDocumentBundle:Abstracts')->getAbstractFromPmid($pmid);
            $abstract = $abstract[0];
        }

        /*
        Here starts the algorithm.
            What we do is create an array from the text and keep track of the positions of this array that have been already hihglighted (using arrayHightlighted) because
            this positions won't be able to be highlighted again.
            It well behave in a different way if the entityName is made of one word o several words!!
                -If entityName is one word only. We change its content inside the array and add the position of the array in arrayHighlighted
                -If entityName is two or more words. We start an iterative process to guess its real position and once it's found, whe highlight
                the firs and last positions keeping track of all of them inside arrayHighligthed

        */

        $arrayText=str_word_count($text, 1, '0..9()=-');
        $arrayHighlighted=array();
        $arrayEntity2Abstract = $em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->findEntity2AbstractFromAbstract($abstract);

        //Next two lines are done to avoid repeated elements and start highlighting from the longest term to the shortest (to avoid "short-tagging")
        $arrayEntity2Abstract=array_unique($arrayEntity2Abstract);
        uasort($arrayEntity2Abstract,array($this, 'name_length_sort_name'));

        foreach ($arrayEntity2Abstract as $entity2Abstract){
            $entityName=$entity2Abstract->getName();//We get the name
            $qualifier=$entity2Abstract->getQualifier();
            $entity2AbstractId=$entity2Abstract->getId();
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            //ld($entityName);
            if (strcasecmp($entityName, $entityBackup) != 0) {
                //sustituimos en el text
                switch ($qualifier) {
                    case 'Marker':
                        $alert="inside Marker";
                        $numberWords=str_word_count($entityName, 0, '0..9()=-');
                        //ld($numberWords);
                        if($numberWords==1){
                            //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                            //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                            foreach($arrayPlaces as $place){
                                array_push($arrayHighlighted, $place);
                                $text=$arrayText[$place];
                                $text = str_ireplace($entityName, '<mark class="marker">'.$entityName.'</mark>', $text);
                                $entityNameUrlEncoded=urlencode($entityName);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "marker",
                                        'source' => $source,
                                        'entityName' => $entityNameUrlEncoded,
                                    )
                                );
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "Marker");
                                $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$entityName."</a></span>", $text);
                                $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                $tooltipCounter=$tooltipCounter+1;
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                                    $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                    //We mark the first
                                    $text=$arrayText[$place];
                                    $text = str_ireplace($arrayEntityName[0], '<mark class="marker">'.$arrayEntityName[0], $text);
                                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"Marker");
                                    $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\">".$arrayEntityName[0], $text);
                                    $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                    $tooltipCounter=$tooltipCounter+1;
                                    $arrayText[$place]=$text;
                                    //Mark the last
                                    $text=$arrayText[$place+$numberEntityName-1];
                                    $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</span></mark>", $text);
                                    $arrayText[$place+$numberEntityName-1]=$text;
                                    //Add all range to arrayHighlighted
                                    foreach(range($place,$place+$numberEntityName-1) as $i){
                                        array_push($arrayHighlighted, $i);
                                    }
                                }
                            }

                        }
                        //ld($text);
                        break;
                    case 'Specie':
                        $alert="inside Specie";
                        $numberWords=str_word_count($entityName, 0, '0..9()=-');
                        if($numberWords==1){
                            //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                            //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                            foreach($arrayPlaces as $place){
                                array_push($arrayHighlighted, $place);
                                $text=$arrayText[$place];
                                $text = str_ireplace($entityName, '<mark class="specie">'.$entityName.'</mark>', $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "Specie");
                                $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\">".$entityName."</span>", $text);
                                $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                $tooltipCounter=$tooltipCounter+1;
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                                    $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                    //We mark the first
                                    $text=$arrayText[$place];
                                    $text = str_ireplace($arrayEntityName[0], '<mark class="specie">'.$arrayEntityName[0], $text);
                                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"Specie");
                                    $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\">".$arrayEntityName[0], $text);
                                    $arrayText[$place]=$text;
                                    $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                    $tooltipCounter=$tooltipCounter+1;
                                    //Mark the last
                                    $text=$arrayText[$place+$numberEntityName-1];
                                    $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</span></mark>", $text);
                                    $arrayText[$place+$numberEntityName-1]=$text;
                                    //Add all range to arrayHighlighted
                                    foreach(range($place,$place+$numberEntityName-1) as $i){
                                        array_push($arrayHighlighted, $i);
                                    }
                                }
                            }
                        }
                        //ld($text);
                        break;
                    case 'CompoundDict' or 'CompoundMesh':
                        $alert="inside CompoundDict";
                        $numberWords=str_word_count($entityName, 0, '0..9()=-');
                        //ld($numberWords);
                        if($numberWords==1){
                            //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                            //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                            foreach($arrayPlaces as $place){
                                $message="entra aqui";
                                array_push($arrayHighlighted, $place);
                                $text=$arrayText[$place];
                                //ld($text);
                                $text = str_ireplace($entityName, '<mark class="compound">'.$entityName.'</mark>', $text);
                                //ld($text);
                                $entityNameUrlEncoded=urlencode($entityName);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "compoundDict",
                                        'source' => $source,
                                        'entityName' => $entityNameUrlEncoded,
                                    )
                                );
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "CompoundDict");
                                $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$entityName."</a></span>", $text);
                                $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                $tooltipCounter=$tooltipCounter+1;
                                $arrayText[$place]=$text;

                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $entityNameUrlEncoded=urlencode($entityName);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "compoundDict",
                                        'source' => $source,
                                        'entityName' => $entityNameUrlEncoded,
                                    )
                                );
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                                    $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                    //We mark the first
                                    $text=$arrayText[$place];
                                    $text = str_ireplace($arrayEntityName[0], '<mark class="compound">'.$arrayEntityName[0], $text);
                                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"CompoundDict");
                                    $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href='$url'>".$arrayEntityName[0], $text);
                                    $arrayText[$place]=$text;
                                    $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                    $tooltipCounter=$tooltipCounter+1;
                                    //Mark the last
                                    $text=$arrayText[$place+$numberEntityName-1];
                                    $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                                    $arrayText[$place+$numberEntityName-1]=$text;
                                    //Add all range to arrayHighlighted
                                    foreach(range($place,$place+$numberEntityName-1) as $i){
                                        array_push($arrayHighlighted, $i);
                                    }
                                }
                            }
                        }
                        //ld($text);
                        break;
                }
            }else{
                //We haven't changed color for entityBackup case insensitive search of entities. We change it now.
                //$text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                $message="inside entityBackup highlight";
                $numberWords=str_word_count($entityName, 0, '0..9()=-');
                if($numberWords==1){
                    $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                    foreach($arrayPlaces as $place){
                        array_push($arrayHighlighted, $place);
                        $text=$arrayText[$place];
                        $text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                        if ($entityType=="CompoundDict" or $entityType=="keyword"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "CompoundDict");
                        }elseif($entityType=="Marker"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "Marker");
                        }elseif($entityType=="Specie"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"Specie");
                        }
                        $text = str_ireplace($entityBackup, "<span data-tooltip=\"sticky$tooltipCounter\">".$entityBackup."</span>", $text);
                        $arrayText[$place]=$text;
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                        $tooltipCounter=$tooltipCounter+1;
                    }
                }else{
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                            $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                            //We mark the first
                            $text=$arrayText[$place];
                            if($entityType=="CompoundDict"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"CompoundDict");
                            }elseif($entityType=="Marker"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"Marker");
                            }elseif($entityType=="Specie"){
                                $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"Specie");
                            }

                            $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\">".$arrayEntityName[0], $text);
                            $arrayText[$place]=$text;
                            $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                            $tooltipCounter=$tooltipCounter+1;

                            //Mark the last
                            $text=$arrayText[$place+$numberEntityName-1];
                            $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</span></mark>", $text);
                            $arrayText[$place+$numberEntityName-1]=$text;
                            //Add all range to arrayHighlighted
                            foreach(range($place,$place+$numberEntityName-1) as $i){
                                array_push($arrayHighlighted, $i);
                            }
                        }
                    }
                }
            }
        }
        $text=implode(" ", $arrayText);
        $arrayReturn=array();
        $arrayReturn[0]=$text;
        $arrayReturn[1]=$mouseoverDivs;
        $arrayReturn[2]=$tooltipCounter;
        return ($arrayReturn);
    }

    public function highlightGenesAbstracts($text,$abstract,$entityBackup,$field, $whatToSearch, $source, $entityType, $tooltipCounter, $orderBy)
    {
        $message="highlightGenesAbstracts!!!";
        //ld($abstract);
        $mouseoverDivs="";
        //ld($text);
        //ld($entityBackup);
        $em=$this->doctrine->getManager();
        //We need all the entities involved in the same document
        //Tweak to use this method with both abstracts and result objects from elasticsearch results
        if($abstract instanceof \EtoxMicrome\DocumentBundle\Entity\Abstracts){
            $className=$abstract->getClassName();
        }else{
            $className=$abstract->getType();
        }
        //ldd($className);
        if($className=="abstracts"){
            //We do nothing, in this case $abstract is already a Abstracts
        }elseif($className=="abstractswithcompounds"){
            $arrayAbstract=$abstract->getSource();
            $pmid=$arrayAbstract['pmid'];
            $abstract = $em->getRepository('EtoxMicromeDocumentBundle:Abstracts')->getAbstractFromPmid($pmid);
            $abstract = $abstract[0];
        }

        /*
        Here starts the algorithm.
            What we do is create an array from the text and keep track of the positions of this array that have been already hihglighted (using arrayHightlighted) because
            this positions won't be able to be highlighted again.
            It well behave in a different way if the entityName is made of one word o several words!!
                -If entityName is one word only. We change its content inside the array and add the position of the array in arrayHighlighted
                -If entityName is two or more words. We start an iterative process to guess its real position and once it's found, whe highlight
                the firs and last positions keeping track of all of them inside arrayHighligthed

        */
        $arrayText=str_word_count($text, 1, '0..9()=-');
        $arrayHighlighted=array();
        $arrayGene2Abstract = $em->getRepository('EtoxMicromeEntity2AbstractBundle:Gene2Abstract')->findGene2AbstractFromAbstract($abstract);
        $arrayGene2Abstract=array_unique($arrayGene2Abstract);
        uasort($arrayGene2Abstract,array($this, 'name_length_sort'));
        foreach ($arrayGene2Abstract as $gene2Abstract){
            $geneName=$gene2Abstract->getGeneName();//We get the name
            $geneName=trim($geneName);
            $qualifier="gene";
            $gene2AbstractId=$gene2Abstract->getId();
            if (strcasecmp($geneName, $entityBackup) != 0) {//We just highlight the entities that are not the same as the gene that is beeing searched
                //If the geneName==entityBackup, we don't do anything, we'll change it at the end
                $alert="inside Gene";
                $numberWords=str_word_count($geneName, 0, '0..9()=-');
                //ld($numberWords);
                if($numberWords==1){
                    //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $arrayPlaces=$this->findPlaceSingleWord($geneName,$arrayText,$arrayHighlighted);
                    //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                    foreach($arrayPlaces as $place){
                        array_push($arrayHighlighted, $place);
                        $text=$arrayText[$place];
                        $text = str_ireplace($geneName, '<mark class="gene">'.$geneName.'</mark>', $text);
                        $geneNameUrlEncoded=urlencode($geneName);
                        $url = $this->generator->generate(
                            'search_interface_search_genes_orderby',
                            array(
                                'whatToSearch' => $whatToSearch,
                                'source' => $source,
                                'entityName' => $geneNameUrlEncoded,
                                'orderBy' => $orderBy,
                            )
                        );
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Gene2Abstract')->getGeneSummary($gene2AbstractId);
                        $text = str_ireplace($geneName, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$geneName."</a></span>", $text);
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                        $tooltipCounter=$tooltipCounter+1;
                        $arrayText[$place]=$text;
                    }

                }else{
                    //This is when the entityName is made by more than one word
                    //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $place=$this->findPlaceSeveralWords($geneName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberGeneyName=str_word_count($geneName, 0);
                        $numberGeneName=str_word_count($geneName, 0, '0..9()=-');
                        if($place+$numberGeneName<=count($arrayText)){//Only in this case is possible to find the geneName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                            $arrayGeneName=str_word_count($geneName, 1, '0..9()=-');
                            //We mark the first
                            $text=$arrayText[$place];
                            $text = str_ireplace($arrayGeneName[0], '<mark class="gene">'.$arrayGeneName[0], $text);
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Gene2Abstract')->getGeneSummary($gene2AbstractId,"Marker");
                            $text = str_ireplace($arrayGeneName[0], "<span data-tooltip=\"sticky$tooltipCounter\">".$arrayGeneName[0], $text);
                            $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                            $tooltipCounter=$tooltipCounter+1;
                            $arrayText[$place]=$text;
                            //Mark the last
                            $text=$arrayText[$place+$numberGeneName-1];
                            $text = str_ireplace($arrayGeneName[$numberGeneName-1], $arrayGeneName[$numberGeneName-1]."</span></mark>", $text);
                            $arrayText[$place+$numberGeneName-1]=$text;
                            //Add all range to arrayHighlighted
                            foreach(range($place,$place+$numberGeneName-1) as $i){
                                array_push($arrayHighlighted, $i);
                            }
                        }
                    }

                }
            }else{
                //We haven't changed color for entityBackup case insensitive search of entities. We change it now.
                //$text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                $message="inside entityBackup highlight";
                $numberWords=str_word_count($geneName, 0, '0..9()=-');
                if($numberWords==1){
                    $arrayPlaces=$this->findPlaceSingleWord($geneName,$arrayText,$arrayHighlighted);
                    foreach($arrayPlaces as $place){
                        array_push($arrayHighlighted, $place);
                        $text=$arrayText[$place];
                        $text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Gene2Abstract')->getGeneSummary($gene2AbstractId);

                        $text = str_ireplace($entityBackup, "<span data-tooltip=\"sticky$tooltipCounter\">".$entityBackup."</span>", $text);
                        $arrayText[$place]=$text;
                        $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                        $tooltipCounter=$tooltipCounter+1;
                    }
                }else{
                    $place=$this->findPlaceSeveralWords($geneName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberGeneName=str_word_count($geneName, 0, '0..9()=-');
                        if($place+$numberGeneName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                            $arrayGeneName=str_word_count($geneName, 1, '0..9()=-');
                            //We mark the firstGene
                            $text=$arrayText[$place];
                            $text = str_ireplace($arrayGeneName[0], '<mark class="termSearched">'.$arrayGeneName[0], $text);
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Gene2Abstract')->getGeneSummary($gene2AbstractId);

                            $text = str_ireplace($arrayGeneName[0], "<span data-tooltip=\"sticky$tooltipCounter\">".$arrayGeneName[0], $text);
                            $arrayText[$place]=$text;
                            $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                            $tooltipCounter=$tooltipCounter+1;

                            //Mark the last
                            $text=$arrayText[$place+$numberGeneName-1];
                            $text = str_ireplace($arrayGeneName[$numberGeneName-1], $arrayGeneName[$numberGeneName-1]."</span></mark>", $text);
                            $arrayText[$place+$numberGeneName-1]=$text;
                            //Add all range to arrayHighlighted
                            foreach(range($place,$place+$numberGeneName-1) as $i){
                                array_push($arrayHighlighted, $i);
                            }
                        }
                    }
                }
            }
        }
        //Once here we should also add the highlights for the rest of the entityTypes
        $arrayEntity2Abstract = $em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->findEntity2AbstractFromAbstract($abstract);
        //ld($arrayText);
        //ld($arrayEntity2Abstract);
        //Next two lines are done to avoid repeated elements and start highlighting from the longest term to the shortest (to avoid "short-tagging")
        $arrayEntity2Abstract=array_unique($arrayEntity2Abstract);
        uasort($arrayEntity2Abstract,array($this, 'name_length_sort_name'));

        foreach ($arrayEntity2Abstract as $entity2Abstract){
            $entityName=$entity2Abstract->getName();//We get the name
            $qualifier=$entity2Abstract->getQualifier();
            $entity2AbstractId=$entity2Abstract->getId();
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            //ld($entityName);
            if (strcasecmp($entityName, $entityBackup) != 0) {
                //sustituimos en el text
                switch ($qualifier) {
                    case 'Marker':
                        $alert="inside Marker";
                        $numberWords=str_word_count($entityName, 0, '0..9()=-');
                        //ld($numberWords);
                        if($numberWords==1){
                            //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                            //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                            foreach($arrayPlaces as $place){
                                array_push($arrayHighlighted, $place);
                                $text=$arrayText[$place];
                                $text = str_ireplace($entityName, '<mark class="marker">'.$entityName.'</mark>', $text);
                                $entityNameUrlEncoded=urlencode($entityName);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "marker",
                                        'source' => $source,
                                        'entityName' => $entityNameUrlEncoded,
                                    )
                                );
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "Marker");
                                $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$entityName."</a></span>", $text);
                                $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                $tooltipCounter=$tooltipCounter+1;
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                                    $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                    //We mark the first
                                    $text=$arrayText[$place];
                                    $text = str_ireplace($arrayEntityName[0], '<mark class="marker">'.$arrayEntityName[0], $text);
                                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"Marker");
                                    $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\">".$arrayEntityName[0], $text);
                                    $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                    $tooltipCounter=$tooltipCounter+1;
                                    $arrayText[$place]=$text;
                                    //Mark the last
                                    $text=$arrayText[$place+$numberEntityName-1];
                                    $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</span></mark>", $text);
                                    $arrayText[$place+$numberEntityName-1]=$text;
                                    //Add all range to arrayHighlighted
                                    foreach(range($place,$place+$numberEntityName-1) as $i){
                                        array_push($arrayHighlighted, $i);
                                    }
                                }
                            }

                        }
                        //ld($text);
                        break;
                    case 'Specie':
                        $alert="inside Specie";
                        $numberWords=str_word_count($entityName, 0, '0..9()=-');
                        if($numberWords==1){
                            //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                            //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                            foreach($arrayPlaces as $place){
                                array_push($arrayHighlighted, $place);
                                $text=$arrayText[$place];
                                $text = str_ireplace($entityName, '<mark class="specie">'.$entityName.'</mark>', $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "Specie");
                                $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\">".$entityName."</span>", $text);
                                $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                $tooltipCounter=$tooltipCounter+1;
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                                    $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                    //We mark the first
                                    $text=$arrayText[$place];
                                    $text = str_ireplace($arrayEntityName[0], '<mark class="specie">'.$arrayEntityName[0], $text);
                                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"Specie");
                                    $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\">".$arrayEntityName[0], $text);
                                    $arrayText[$place]=$text;
                                    $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                    $tooltipCounter=$tooltipCounter+1;
                                    //Mark the last
                                    $text=$arrayText[$place+$numberEntityName-1];
                                    $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</span></mark>", $text);
                                    $arrayText[$place+$numberEntityName-1]=$text;
                                    //Add all range to arrayHighlighted
                                    foreach(range($place,$place+$numberEntityName-1) as $i){
                                        array_push($arrayHighlighted, $i);
                                    }
                                }
                            }
                        }
                        //ld($text);
                        break;
                    case 'CompoundDict' or 'CompoundMesh':
                        $alert="inside CompoundDict or CommpoundMesh";
                        $numberWords=str_word_count($entityName, 0, '0..9()=-');
                        if($numberWords==1){
                            //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                            //ld($arrayPlaces);
                            //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                            foreach($arrayPlaces as $place){
                                $message="entra aqui";
                                array_push($arrayHighlighted, $place);
                                $text=$arrayText[$place];
                                //ld($text);
                                $text = str_ireplace($entityName, '<mark class="compound">'.$entityName.'</mark>', $text);
                                //ld($text);
                                $entityNameUrlEncoded=urlencode($entityName);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "compoundDict",
                                        'source' => $source,
                                        'entityName' => $entityNameUrlEncoded,
                                    )
                                );
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "CompoundDict");
                                $text = str_ireplace($entityName, "<span data-tooltip=\"sticky$tooltipCounter\"><a href=\"$url\">".$entityName."</a></span>", $text);
                                $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                $tooltipCounter=$tooltipCounter+1;
                                $arrayText[$place]=$text;

                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $entityNameUrlEncoded=urlencode($entityName);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "compoundDict",
                                        'source' => $source,
                                        'entityName' => $entityNameUrlEncoded,
                                    )
                                );
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                if($place+$numberEntityName<=count($arrayText)){//Only in this case is possible to find the entityName inside the text, otherwise it will fall outside the array with undefined offset error_get_last()
                                    $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                    //We mark the first
                                    $text=$arrayText[$place];
                                    $text = str_ireplace($arrayEntityName[0], '<mark class="compound">'.$arrayEntityName[0], $text);
                                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"CompoundDict");
                                    $text = str_ireplace($arrayEntityName[0], "<span data-tooltip=\"sticky$tooltipCounter\"><a href='$url'>".$arrayEntityName[0], $text);
                                    $arrayText[$place]=$text;
                                    $mouseoverDivs=$mouseoverDivs."<div id=\"sticky$tooltipCounter\" class=\"atip\">$mouseoverSummary</div>";
                                    $tooltipCounter=$tooltipCounter+1;
                                    //Mark the last
                                    $text=$arrayText[$place+$numberEntityName-1];
                                    $text = str_ireplace($arrayEntityName[$numberEntityName-1], $arrayEntityName[$numberEntityName-1]."</a></span></mark>", $text);
                                    $arrayText[$place+$numberEntityName-1]=$text;
                                    //Add all range to arrayHighlighted
                                    foreach(range($place,$place+$numberEntityName-1) as $i){
                                        array_push($arrayHighlighted, $i);
                                    }
                                }
                            }
                        }//end_else
                        //ld($text);
                        break;
                }//end_switch
            }//end_if
        }//end_foreach
        $text=implode(" ", $arrayText);
        $arrayReturn=array();
        $arrayReturn[0]=$text;
        $arrayReturn[1]=$mouseoverDivs;
        $arrayReturn[2]=$tooltipCounter;
        ldd($arrayReturn);
        return ($arrayReturn);
    }

    public function highlightKeywordText($text,$keyword)
    {
        $message="highlightKeywordText!!!";
        $text = str_ireplace($keyword, '<mark class="keyword">'.$keyword.'</mark>', $text);
        return ($text);
    }

    public function highlightRelations($text,$sentenceId,$entityBackup, $whatToSearch)
    {
        //Cutre highlight para salir del paso durante la live demo del viernes 7 de febrero 2014
        //We have to search for all the relations that are with the same sentenceId
        $em=$this->doctrine->getManager();
        if($whatToSearch=="compoundsTermsRelations"){
            $arrayRelations=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Term2Document')->getAllRelationsFromSentenceId($sentenceId)->getResult();
            //For each relation we have to highlight a Compound and a Term
            foreach($arrayRelations as $relation){
                $compound=$relation->getCompound();
                $term=$relation->getTerm();
                $text=str_ireplace($compound, "<mark class='compound'>$compound</mark>", $text);
                $text=str_ireplace($term, "<mark class='term'>$term</mark>", $text);
            }
        }

        if($whatToSearch=="compoundsCytochromesRelations"){
            $arrayRelations=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Cyp2Document')->getAllRelationsFromSentenceId($sentenceId)->getResult();
            //For each relation we have to highlight a Compound and a Cyp
            foreach($arrayRelations as $relation){
                $compound=$relation->getCompound();
                $cyp=$relation->getCyp();
                $text=str_ireplace($compound, "<mark class='compound'>$compound</mark>", $text);
                $text=str_ireplace($cyp, "<mark class='cytochrome'>$cyp</mark>", $text);
            }
        }

        if($whatToSearch=="compoundsMarkersRelations"){
            $arrayRelations=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Marker2Document')->getAllRelationsFromSentenceId($sentenceId)->getResult();
            //For each relation we have to highlight a Compound and a Marker
            foreach($arrayRelations as $relation){
                $compound=$relation->getCompound();
                $marker=$relation->getLiverMarkerName();
                $text=str_ireplace($compound, "<mark class='compound'>$compound</mark>", $text);
                $text=str_ireplace($marker, "<mark class='marker'>$marker</mark>", $text);
            }
        }
        return($text);



    }

    public function colorCodingScore($score)
    {
        $message="colorCodingScore!!!";
        if ($score==null){
            $score="-";
            return $score;
        }
        $score=(float)$score;
        switch ($score) {
            case (int)$score === 0:
                    $score ="<mark class=''>$score</mark>";
                    break;
            case $score>5:
                    $score ="<mark class='score-green-5'>$score</mark>";
                    break;
            case $score>4:
                    $score ="<mark class='score-green-4'>$score</mark>";
                    break;
            case $score>3:
                    $score ="<mark class='score-green-3'>$score</mark>";
                    break;
            case $score>2:
                    $score ="<mark class='score-green-2'>$score</mark>";
                    break;
            case $score>1:
                    $score ="<mark class='score-green-1'>$score</mark>";
                    break;
            case $score>0:
                    $score ="<mark class='score-green-0'>$score</mark>";
                    break;
            case $score < -5:
                    $score ="<mark class='score-red-5'>$score</mark>";
                    break;
            case $score < -4:
                    $score ="<mark class='score-red-4'>$score</mark>";
                    break;
            case $score < -3:
                    $score ="<mark class='score-red-3'>$score</mark>";
                    break;
            case $score < -2:
                    $score ="<mark class='score-red-2'>$score</mark>";
                    break;
            case $score < -1:
                    $score ="<mark class='score-red-1'>$score</mark>";
                    break;
            case $score < 0:
                    $score ="<mark class='score-red-0'>$score</mark>";
                    break;


        }
        return ($score);
    }

    public function setCurationHtml($curation, $entity2Document, $entityType, $source)
    {
        if($entityType=="CompoundDict"){
            if($source=="document"){
                $url_check = $this->generator->generate(
                    'ajax_entity2document_curation',
                    array(
                        'entity2Document' => $entity2Document,
                        'action' => "check",
                    )
                );
                $url_cross = $this->generator->generate(
                    'ajax_entity2document_curation',
                    array(
                        'entity2Document' => $entity2Document,
                        'action' => "cross",
                    )
                );

                if($curation<0){
                    $htmlCuration="<a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateEntity2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }elseif($curation==0){
                    $htmlCuration="<a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateEntity2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }elseif($curation>0){
                    $htmlCuration="<a class='check-yes check' id=\"check-$entity2Document\" onclick=\"curateEntity2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }

            }elseif($source=="abstract"){

                $url_check = $this->generator->generate(
                    'ajax_entity2abstract_curation',
                    array(
                        'entity2Abstract' => $entity2Document,
                        'action' => "check",
                    )
                );
                $url_cross = $this->generator->generate(
                    'ajax_entity2abstract_curation',
                    array(
                        'entity2Abstract' => $entity2Document,
                        'action' => "cross",
                    )
                );
                if($curation<0){
                    $htmlCuration="<a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateEntity2Abstract('$url_check',$entity2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Abstract('$url_cross',$entity2Document,'cross')\"> </a>";
                }elseif($curation==0){
                    $htmlCuration="<a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateEntity2Abstract('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Abstract('$url_cross',$entity2Document,'cross')\"> </a>";
                }elseif($curation>0){
                    $htmlCuration="<a class='check-yes check' id=\"check-$entity2Document\" onclick=\"curateEntity2Abstract('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Abstract('$url_cross',$entity2Document,'cross')\"> </a>";
                }
            }elseif($source=="Compound2Term2Document"){
                $url_check = $this->generator->generate(
                    'ajax_compound2term2document_curation',
                    array(
                        'compound2Term2Document' => $entity2Document,
                        'action' => "check",
                    )
                );
                $url_cross = $this->generator->generate(
                    'ajax_compound2term2document_curation',
                    array(
                        'compound2Term2Document' => $entity2Document,
                        'action' => "cross",
                    )
                );

                if($curation<0){
                    $htmlCuration="<a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateCompound2Term2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$entity2Document\" onclick=\"curateCompound2Term2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }elseif($curation==0){
                    $htmlCuration="<a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateCompound2Term2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateCompound2Term2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }elseif($curation>0){
                    $htmlCuration="<a class='check-yes check' id=\"check-$entity2Document\" onclick=\"curateCompound2Term2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateCompound2Term2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }

            }
        }elseif($entityType=="Cytochrome"){
            if($source=="document")
            {
                $cytochrome2Document=$entity2Document;
                $url_check = $this->generator->generate(
                    'ajax_cytochrome2document_curation',
                    array(
                        'cytochrome2Document' => $cytochrome2Document,
                        'action' => "check",
                    )
                );
                $url_cross = $this->generator->generate(
                    'ajax_cytochrome2document_curation',
                    array(
                        'cytochrome2Document' => $cytochrome2Document,
                        'action' => "cross",
                    )
                );

                if($curation<0){
                    $htmlCuration="<a class='check-no check' id=\"check-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_check',$cytochrome2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_cross',$cytochrome2Document,'cross')\"> </a>";
                }elseif($curation==0){
                    $htmlCuration="<a class='check-no check' id=\"check-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_check',$cytochrome2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_cross',$cytochrome2Document,'cross')\"> </a>";
                }elseif($curation>0){
                    $htmlCuration="<a class='check-yes check' id=\"check-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_check',$cytochrome2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_cross',$cytochrome2Document,'cross')\"> </a>";
                }

            }
            elseif($source=="Compound2Cyp2Document"){
                $url_check = $this->generator->generate(
                    'ajax_compound2cyp2document_curation',
                    array(
                        'compound2Cyp2Document' => $entity2Document,
                        'action' => "check",
                    )
                );
                $url_cross = $this->generator->generate(
                    'ajax_compound2cyp2document_curation',
                    array(
                        'compound2Cyp2Document' => $entity2Document,
                        'action' => "cross",
                    )
                );

                if($curation<0){
                    $htmlCuration="<a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateCompound2Cyp2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$entity2Document\" onclick=\"curateCompound2Cyp2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }elseif($curation==0){
                    $htmlCuration="<a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateCompound2Cyp2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateCompound2Cyp2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }elseif($curation>0){
                    $htmlCuration="<a class='check-yes check' id=\"check-$entity2Document\" onclick=\"curateCompound2Cyp2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateCompound2Cyp2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }

            }
        }elseif($entityType=="Marker"){
            if($source=="document")
            {
                $marker2Document=$entity2Document;
                $url_check = $this->generator->generate(
                    'ajax_marker2document_curation',
                    array(
                        'marker2Document' => $marker2Document,
                        'action' => "check",
                    )
                );
                $url_cross = $this->generator->generate(
                    'ajax_marker2document_curation',
                    array(
                        'marker2Document' => $marker2Document,
                        'action' => "cross",
                    )
                );

                if($curation<0){
                    $htmlCuration="<a class='check-no check' id=\"check-$marker2Document\" onclick=\"curateEntity2Document('$url_check',$marker2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$marker2Document\" onclick=\"curateEntity2Document('$url_cross',$marker2Document,'cross')\"> </a>";
                }elseif($curation==0){
                    $htmlCuration="<a class='check-no check' id=\"check-$marker2Document\" onclick=\"curateEntity2Document('$url_check',$marker2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$marker2Document\" onclick=\"curateEntity2Document('$url_cross',$marker2Document,'cross')\"> </a>";
                }elseif($curation>0){
                    $htmlCuration="<a class='check-yes check' id=\"check-$marker2Document\" onclick=\"curateEntity2Document('$url_check',$marker2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$marker2Document\" onclick=\"curateEntity2Document('$url_cross',$marker2Document,'cross')\"> </a>";
                }

            }
             elseif($source=="Compound2Marker2Document"){
                $url_check = $this->generator->generate(
                    'ajax_compound2marker2document_curation',
                    array(
                        'compound2Marker2Document' => $entity2Document,
                        'action' => "check",
                    )
                );
                $url_cross = $this->generator->generate(
                    'ajax_compound2marker2document_curation',
                    array(
                        'compound2Marker2Document' => $entity2Document,
                        'action' => "cross",
                    )
                );

                if($curation<0){
                    $htmlCuration="<a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateCompound2Marker2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$entity2Document\" onclick=\"curateCompound2Marker2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }elseif($curation==0){
                    $htmlCuration="<a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateCompound2Marker2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateCompound2Marker2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }elseif($curation>0){
                    $htmlCuration="<a class='check-yes check' id=\"check-$entity2Document\" onclick=\"curateCompound2Marker2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateCompound2Marker2Document('$url_cross',$entity2Document,'cross')\"> </a>";
                }

            }
        }



        return($htmlCuration);
    }
    public function getScoreToShow($orderBy){
        switch ($orderBy) {
            case $orderBy == "hepval":
                $orderBy ="SVM";
                break;
            case $orderBy == "svmConfidence":
                $orderBy ="Conf.";
                break;
            case $orderBy == "patternCount":
                $orderBy ="Pattern";
                break;
            case $orderBy == "hepTermVarScore":
                $orderBy ="Term";
                break;
            case $orderBy == "ruleScore":
                $orderBy ="Rule";
                break;
        }
        return $orderBy;
    }

    public function getScoreToShowRelations($orderBy){
        switch ($orderBy) {
            case $orderBy == "hepval":
                $orderBy ="Induct.";
                break;
            case $orderBy == "inductionScore":
                $orderBy ="Induct.";
                break;
            case $orderBy == "inhibitionScore":
                $orderBy ="Inhib.";
                break;
            case $orderBy == "metabolismScore":
                $orderBy ="Metab.";
                break;
        }
        return $orderBy;
    }

    public function getOrderToSource($orderBy){
        switch ($orderBy) {
            case $orderBy == "score":
                $orderBy ="hepval";
                break;
            case $orderBy == "svmConfidence":
                $orderBy ="svmConfidence";
                break;
            case $orderBy == "pattern":
                $orderBy ="patternCount";
                break;
            case $orderBy == "term":
                $orderBy ="hepTermVarScore";
                break;
            case $orderBy == "rule":
                $orderBy ="ruleScore";
                break;
        }
        return $orderBy;
    }
    public function getName()
    {
        return 'utility';
    }
}


?>