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
        'highlightEntitiesAbstracts' => new \Twig_Filter_Method($this, 'highlightEntitiesAbstracts'),
        'highlightKeywordText' => new \Twig_Filter_Method($this, 'highlightKeywordText'),
        'colorCodingScore' => new \Twig_Filter_Method($this, 'colorCodingScore'),
        'setCurationHtml' => new \Twig_Filter_Method($this, 'setCurationHtml'),
        );
    }

    public function findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted)
    {
        //Returns an array with the valid position/s to make the highlight or a void array if there is no position...
        $arrayPositions=array();
        foreach($arrayText as $i => $word){
            if(strcasecmp($word, $entityName)==0){
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
            //ld($startingPlace);
            $counter=0;
            for($i=$startingPlace;$i<$startingPlace+$numberOfEntityNames;$i++){
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

    public function highlightEntitiesDocuments($text,$document,$entityBackup, $field, $whatToSearch, $source, $entityType)
    {
        //the parameters $field, $whatToSearch, $entityType are used to create the url to link the entities to a search of theirshelves
        $message="highlightEntitiesDocuments!!!";
        //ld($text);
        //ld($entityType);
        //ld($entityBackup);
        //ld($whatToSearch);
        //ld($document);
        $em=$this->doctrine->getManager();
        //We need all the entities involved in the same document


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
        //ld($arrayText);
        $arrayHighlighted=array();

        //With arrayHepKeywordTermVariant2Document we can highlight Hepatotoxicity Terms
        $arrayHepKeywordTermVariant2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:HepKeywordTermVariant2Document')->findHepKeywordTermVariant2Document($document);
        foreach ($arrayHepKeywordTermVariant2Document as $term2Document){
            $entityName=$term2Document->getTermVariant();
            //ld($entityName);
            //ld($entityBackup);
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
                        $text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityName."</span>", $text);
                        $arrayText[$place]=$text;
                        array_push($arrayHighlighted, $place);
                    }

                }else{
                    //This is when the entityName is made by more than one word
                    //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                        //We mark the first
                        $text=$arrayText[$place];
                        $text = str_ireplace($arrayEntityName[0], '<mark class="term">'.$arrayEntityName[0], $text);
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermVariant");
                        $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
                        if($entityType=="keyword"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermVariant");
                        }elseif($entityType=="keyword"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");
                        }elseif($entityType=="keyword"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepatotoxKeyword");
                        }

                        $text = str_ireplace($entityBackup, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityBackup."</span>", $text);
                        $arrayText[$place]=$text;
                        array_push($arrayHighlighted, $place);
                    }
                }else{
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
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

                        $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
        }

        //With arrayCytochrome2Document we can highlight Cytochromes
        $arrayCytochrome2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Cytochrome2Document')->findCytochrome2DocumentFromDocument($document);
        //ld($arrayCytochrome2Document);

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
                        $text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityName."</span>", $text);
                        $arrayText[$place]=$text;
                    }
                }else{
                    //This is when the entityName is made by more than one word
                    //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                        //We mark the first
                        $text=$arrayText[$place];
                        $text = str_ireplace($arrayEntityName[0], '<mark class="cytochrome">'.$arrayEntityName[0], $text);
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($cytochrome2DocumentId,"Cytochrome");
                        $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
                        $text = str_ireplace($entityBackup, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityBackup."</span>", $text);
                        $arrayText[$place]=$text;
                    }
                }else{
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                        //We mark the first
                        $text=$arrayText[$place];
                        $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($cytochrome2DocumentId,"Cytochrome");
                        $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
        }

        //With arrayHepKeywordTermNorm2Document we can highlight Hepatotoxicity Terms
        $arrayHepKeywordTermNorm2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:HepKeywordTermNorm2Document')->findHepKeywordTermNorm2Document($document);
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
                        $text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityName."</span>", $text);
                        $arrayText[$place]=$text;
                    }

                }else{
                    //This is when the entityName is made by more than one word
                    //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                        //We mark the first
                        $text=$arrayText[$place];
                        $text = str_ireplace($arrayEntityName[0], '<mark class="term">'.$arrayEntityName[0], $text);
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");
                        $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
                $text = str_ireplace($entityName, '<mark class="term">'.$entityName.'</mark>', $text);
                //$mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");

                //$text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityName."</span>", $text);
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
                        if($entityType=="HepKeywordTermVariant"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermVariant");
                        }elseif($entityType=="HepKeywordTermNorm"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepKeywordTermNorm");
                        }elseif($entityType=="HepatotoxKeyword"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($term2DocumentId,"HepatotoxKeyword");
                        }

                        $text = str_ireplace($entityBackup, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityBackup."</span>", $text);
                        $arrayText[$place]=$text;
                    }
                }else{
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
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

                        $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
            //We also add a link around the Term in order to search co-mentioned terms
        }


        //With arrayEntity2Document we can highlight CompoundDict, Marker and Specie
        $arrayEntity2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->findEntity2DocumentFromDocument($document);
        //ld($arrayEntity2Document);
        foreach ($arrayEntity2Document as $entity2Document){
            $entityName=$entity2Document->getName();
            //ld($entityName);
            $qualifier=$entity2Document->getQualifier();
            $entity2DocumentId=$entity2Document->getId();
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            if (strcasecmp($entityName, $entityBackup) != 0) {
                //sustituimos en el text
                //ld($entityName);
                //ld($qualifier);
                switch ($qualifier) {
                    case 'Marker':
                        $alert="entra en Marker";
                        //ld($alert);
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
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "marker",
                                        'source' => $source,
                                        'entityName' => $entityName,
                                    )
                                );
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId, "Marker");
                                $text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'><a href='$url'>".$entityName."</a></span>", $text);
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                //We mark the first
                                $text=$arrayText[$place];
                                $text = str_ireplace($arrayEntityName[0], '<mark class="marker">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"Marker");
                                $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
                                $text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityName."</span>", $text);
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                //We mark the first
                                $text=$arrayText[$place];
                                $text = str_ireplace($arrayEntityName[0], '<mark class="specie">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"Specie");
                                $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
                        //ld($text);
                        break;
                    case 'CompoundDict':
                        $alert="entra en CompoundDict";
                        //ld($alert);

                        $numberWords=str_word_count($entityName, 0, '0..9()=-');
                        //ld($numberWords);
                        if($numberWords==1){
                            //We search a possible place/s for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $arrayPlaces=$this->findPlaceSingleWord($entityName,$arrayText,$arrayHighlighted);
                            //Once the positions are knwon, we do the replacement inside the positions of the $arrayText and keep the track of the position
                            foreach($arrayPlaces as $place){
                                array_push($arrayHighlighted, $place);
                                $text=$arrayText[$place];
                                $text = str_ireplace($entityName, '<mark class="compound">'.$entityName.'</mark>', $text);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "compoundDict",
                                        'source' => $source,
                                        'entityName' => $entityName,
                                    )
                                );
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId, "CompoundDict");
                                $text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'><a href='$url'>".$entityName."</a></span>", $text);
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "compoundDict",
                                        'source' => $source,
                                        'entityName' => $entityName,
                                    )
                                );
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                //We mark the first
                                $text=$arrayText[$place];
                                $text = str_ireplace($arrayEntityName[0], '<mark class="compound">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"CompoundDict");
                                $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'><a href='$url'>".$arrayEntityName[0], $text);
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
                        //ld($text);
                        break;
                }
            }else{
                //We haven't changed color for entityBackup case insensitive search of entities. We change it now.
                //$text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
                $numberWords=str_word_count($entityName, 0, '0..9()=-');
                //ld($numberWords);
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
                        $text = str_ireplace($entityBackup, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityBackup."</span>", $text);
                        $arrayText[$place]=$text;

                    }
                }else{
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                        $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                        //We mark the first
                        $text=$arrayText[$place];
                        if($entityType=="CompoundDict"){
                            $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"CompoundDict");
                        }elseif($entityType=="Marker"){
                            $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"Marker");
                        }elseif($entityType=="Specie"){
                            $text = str_ireplace($arrayEntityName[0], '<mark class="termSearched">'.$arrayEntityName[0], $text);
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummary($entity2DocumentId,"Specie");
                        }

                        $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
        }
        //ld($entityBackup);
        $text=implode(" ", $arrayText);
        return ($text);
    }

    public function highlightEntitiesAbstracts($text,$abstract,$entityBackup,$field, $whatToSearch, $source, $entityType)
    {
        $message="highlightEntitiesAbstracts!!!";
        //ld($text);
        //ld($entityBackup);
        $em=$this->doctrine->getManager();
        //We need all the entities involved in the same document
        $className=$abstract->getClassName();
        //ld($className);
        if($className=="Abstracts"){
            //We do nothing, in this case $abstract is already a Abstracts
        }elseif($className=="AbstractWithCompound"){
            $abstract = $em->getRepository('EtoxMicromeDocumentBundle:Abstracts')->getAbstractFromAbstractWith($abstract);
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
                        $alert="entra en Marker";
                        //ld($alert);
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
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "marker",
                                        'source' => $source,
                                        'entityName' => $entityName,
                                    )
                                );
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "Marker");
                                $text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'><a href='$url'>".$entityName."</a></span>", $text);
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                //We mark the first
                                $text=$arrayText[$place];
                                $text = str_ireplace($arrayEntityName[0], '<mark class="marker">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"Marker");
                                $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "Specie");
                                $text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityName."</span>", $text);
                                $arrayText[$place]=$text;
                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                //We mark the first
                                $text=$arrayText[$place];
                                $text = str_ireplace($arrayEntityName[0], '<mark class="specie">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"Specie");
                                $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
                        //ld($text);
                        break;
                    case 'CompoundDict' or 'CompoundMesh':
                        $alert="entra en CompoundDict";
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
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "compoundDict",
                                        'source' => $source,
                                        'entityName' => $entityName,
                                    )
                                );
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "CompoundDict");
                                $text = str_ireplace($entityName, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'><a href='$url'>".$entityName."</a></span>", $text);
                                $arrayText[$place]=$text;

                            }

                        }else{
                            //This is when the entityName is made by more than one word
                            //We search a range of positions for the highlight iterating over the arrayText taking into account the arrayHighlighted positions already highlighted
                            $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                            if($place!=-1){
                                //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                                $url = $this->generator->generate(
                                    'search_interface_search_field_whatToSearch_entityType_source_entity',
                                    array(
                                        'field' => $field,
                                        'whatToSearch' => $whatToSearch,
                                        'entityType' => "compoundDict",
                                        'source' => $source,
                                        'entityName' => $entityName,
                                    )
                                );
                                $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
                                $arrayEntityName=str_word_count($entityName, 1, '0..9()=-');
                                //We mark the first
                                $text=$arrayText[$place];
                                $text = str_ireplace($arrayEntityName[0], '<mark class="compound">'.$arrayEntityName[0], $text);
                                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"CompoundDict");
                                $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'><a href='$url'>".$arrayEntityName[0], $text);
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
                        //ld($text);
                        break;
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
                        if ($entityType=="CompoundDict" or $entityType=="keyword"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "CompoundDict");
                        }elseif($entityType=="Marker"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId, "Marker");
                        }elseif($entityType=="Specie"){
                            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntitySummary($entity2AbstractId,"Specie");
                        }
                        $text = str_ireplace($entityBackup, "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$entityBackup."</span>", $text);
                        $arrayText[$place]=$text;
                    }
                }else{
                    $place=$this->findPlaceSeveralWords($entityName,$arrayText,$arrayHighlighted);
                    if($place!=-1){
                        //There is a place to make the highlight, starting at $place and finishing at $numberEntityName=str_word_count($entityName, 0);
                        $numberEntityName=str_word_count($entityName, 0, '0..9()=-');
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

                        $text = str_ireplace($arrayEntityName[0], "<span data-tooltip class='has-tip' data-options='touch_close_text:tap to close' title='".$mouseoverSummary."'>".$arrayEntityName[0], $text);
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
        }
        $text=implode(" ", $arrayText);
        return ($text);
    }

    public function highlightKeywordText($text,$keyword)
    {
        $message="highlightKeywordText!!!";
        $text = str_ireplace($keyword, '<mark class="keyword">'.$keyword.'</mark>', $text);
        return ($text);
    }

    public function colorCodingScore($score)
    {
        $message="colorCodingScore!!!";
        $score=(float)$score;
        switch ($score) {
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
        }



        return($htmlCuration);
    }
    public function getName()
    {
        return 'utility';
    }
}


?>