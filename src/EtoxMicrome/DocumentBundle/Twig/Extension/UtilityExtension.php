<?php

namespace EtoxMicrome\DocumentBundle\Twig\Extension;

use Symfony\Bridge\Doctrine\RegistryInterface;
use EtoxMicrome\Entity2DocumentBundle\Entity\Entity2Document;
use EtoxMicrome\DocumentBundle\Entity\DocumentWithCompound;
use Twig_Extension;
use Twig_Filter_Method;

class UtilityExtension extends \Twig_Extension
{
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFilters()
    {
        return array(
        'highlightEntitiesDocuments' => new \Twig_Filter_Method($this, 'highlightEntitiesDocuments'),
        'highlightEntitiesAbstracts' => new \Twig_Filter_Method($this, 'highlightEntitiesAbstracts'),
        'highlightKeywordText' => new \Twig_Filter_Method($this, 'highlightKeywordText'),
        'colorCodingScore' => new \Twig_Filter_Method($this, 'colorCodingScore'),
        );
    }

    public function highlightEntitiesDocuments($text,$document,$entityBackup)
    {
        $message="highlightEntitiesDocuments!!!";
        //ld($message);
        //ld($text);
        //ld($document);
        $em=$this->doctrine->getManager();
        //We need all the entities involved in the same document


        //Sometimes $document is not a Document but a DocumentWithCompound or DocumentWithCytochrome etc...
        $className=$document->getClassName();
        if($className=="Document"){
            //We do nothing, in this case $document is already a Document
        }elseif($className=="DocumentWithCompound" or $className=="DocumentWithCytochrome" or $className=="DocumentWithMarker"){
            $document = $em->getRepository('EtoxMicromeDocumentBundle:Document')->getDocumentFromDocumentWith($document);
            $document = $document[0];
        }

        //With arrayEntity2Document we can highlight CompoundDict, Marker and Specie
        $arrayEntity2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->findEntity2DocumentFromDocument($document);

        foreach ($arrayEntity2Document as $entity2Document){
            $entityName=$entity2Document->getName();
            $qualifier=$entity2Document->getQualifier();
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            if (strcasecmp($entityName, $entityBackup) != 0) {
                //sustituimos en el text
                //ld($entityName);
                //ld($qualifier);
                switch ($qualifier) {
                    case 'Marker':
                        $alert="entra en Term";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="marker">'.$entityName.'</mark>', $text);
                        break;
                    case 'Specie':
                        $alert="entra en Specie";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="specie">'.$entityName.'</mark>', $text);
                        //ld($text);
                        break;
                    case 'CompoundDict':
                        $alert="entra en CompoundDict";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="compound">'.$entityName.'</mark>', $text);
                        break;
                }
            }
        }


        //With arrayCytochrome2Document we can highlight Cytochromes
        $arrayCytochrome2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Cytochrome2Document')->findCytochrome2DocumentFromDocument($document);
        foreach ($arrayCytochrome2Document as $cytochrome2Document){
            $entityName=$cytochrome2Document->getCypsMention();
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            if (strcasecmp($entityName, $entityBackup) != 0) {
                $text = str_ireplace($entityName, '<mark class="cyp">'.$entityName.'</mark>', $text);
            }
        }


        //With arrayHepKeywordTermVariant2Document we can highlight Hepatotoxicity Terms
        $arrayHepKeywordTermVariant2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:HepKeywordTermVariant2Document')->findHepKeywordTermVariant2Document($document);
        foreach ($arrayHepKeywordTermVariant2Document as $term2Document){
            $entityName=$term2Document->getTermVariant();
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            if (strcasecmp($entityName, $entityBackup) != 0) {
                $text = str_ireplace($entityName, '<mark class="term">'.$entityName.'</mark>', $text);
            }
        }

        //With arrayHepKeywordTermNorm2Document we can highlight Hepatotoxicity Terms
        $arrayHepKeywordTermNorm2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:HepKeywordTermNorm2Document')->findHepKeywordTermNorm2Document($document);
        foreach ($arrayHepKeywordTermNorm2Document as $term2Document){
            $entityName=$term2Document->getHepKeywordNorm();
            //If the name==entityBackup, we don't do anything, we'll change it at the end
            if (strcasecmp($entityName, $entityBackup) != 0) {
                $text = str_ireplace($entityName, '<mark class="term">'.$entityName.'</mark>', $text);
            }
        }


        //We haven't changed color for entityBackup case insensitive search of entities. We change it now.
        $text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
        return ($text);
    }

    public function highlightEntitiesAbstracts($text,$abstract,$entityBackup)
    {
        $message="highlightEntitiesAbstracts!!!";
        //ld($text);
        //ld($entityBackup);
        $em=$this->doctrine->getManager();
        //We need all the entities involved in the same document
        $className=$abstract->getClassName();
        if($className=="Abstracts"){
            //We do nothing, in this case $abstract is already a Abstracts
        }elseif($className=="AbstractWithCompound"){
            $abstract = $em->getRepository('EtoxMicromeDocumentBundle:Abstracts')->getAbstractFromAbstractWith($abstract);
            $abstract = $abstract[0];
        }
        //ld($abstract);
        $arrayEntity2Abstract = $em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->findEntity2AbstractFromAbstract($abstract);
        //ld($arrayEntity2Abstract);
        foreach ($arrayEntity2Abstract as $entity2Abstract){
            $entityName=$entity2Abstract->getName();//We get the name
            $qualifier=$entity2Abstract->getQualifier();
            //ld($entityName);
            //ld($qualifier);

            //If the name==entityBackup, we don't do anything, we'll change it at the end
            if (strcasecmp($entityName, $entityBackup) != 0) {
                //sustituimos en el text
                //ld($entityName);
                //ld($qualifier);
                switch ($qualifier) {
                    case 'Marker':
                        $alert="entra en Term";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="marker">'.$entityName.'</mark>', $text);
                        break;
                    case 'Specie':
                        $alert="entra en Specie";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="specie">'.$entityName.'</mark>', $text);
                        //ld($text);
                        break;
                    case 'CompoundDict' or 'CompoundMesh':
                        $alert="entra en CompoundDict";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="compound">'.$entityName.'</mark>', $text);
                        break;
                }
            }
        }
        //We haven't changed color for entityBackup case insensitive search of entities. We change it now.
        $text = str_ireplace($entityBackup, '<mark class="termSearched">'.$entityBackup.'</mark>', $text);
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

    public function getName()
    {
        return 'utility';
    }
}


?>