<?php

namespace EtoxMicrome\DocumentBundle\Twig\Extension;

use Symfony\Bridge\Doctrine\RegistryInterface;
use EtoxMicrome\Entity2DocumentBundle\Entity\Entity2Document;
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
        $arrayEntity2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->findEntity2DocumentFromDocument($document);
        //ld($arrayEntity2Document);
        foreach ($arrayEntity2Document as $entity2Document){
            //To get the name of the entity we have to take into account the entityId and the qualifier, in order to search in the correct entity table.
            $entityName=$entity2Document->getName();
            $qualifier=$entity2Document->getQualifier();
            //ld($entityId);
            //$entity=$em->getRepository('EtoxMicromeEntityBundle:'.$qualifier)->getEntityFromId($entityId);
            //$entityName=$entity->getName();
            //ld($entityName);
            //ld($qualifier);
            //ld($tipo);

            //If the name==entityBackup, we don't do anything, we'll change it at the end
            if (strcasecmp($entityName, $entityBackup) != 0) {
                //sustituimos en el text
                switch ($qualifier) {
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
                    case 'CompoundNer':
                        $alert="entra en CompoundNer";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="compound">'.$entityName.'</mark>', $text);
                        break;
                    case 'CompoundMesh':
                        $alert="entra en CompoundMesh";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="compound">'.$entityName.'</mark>', $text);
                        break;
                    case 'Enzyme':
                        $alert="entra en Enzyme ";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="enzyme">'.$entityName.'</mark>', $text);
                        break;
                    case 'EnzymeMesh':
                        $alert="entra en EnzymeMesh";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="enzyme">'.$entityName.'</mark>', $text);
                        break;
                    case 'EnzymeDict':
                        $alert="entra en EnzymeDict";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="enzyme">'.$entityName.'</mark>', $text);
                        break;
                    case 'Protein':
                        $alert="entra en Protein";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="protein">'.$entityName.'</mark>', $text);
                        break;
                    case 'Cyp' :
                        $alert="entra en Cyp";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="cyp">'.$entityName.'</mark>', $text);
                        break;
                    case 'CypDict':
                        $alert="entra en CypDict";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="cyp">'.$entityName.'</mark>', $text);
                        break;
                    case 'CypRuleBased':
                        $alert="entra en CypRuleBased";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="cyp">'.$entityName.'</mark>', $text);
                        break;
                    case 'Mutation':
                        $alert="entra en Mutation";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="mutation">'.$entityName.'</mark>', $text);
                        break;
                    case 'GoTerm':
                        $alert="entra en GoTerm";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="go_term">'.$entityName.'</mark>', $text);
                        break;
                    case 'Keyword':
                        $alert="entra en Keyword";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="keyword">'.$entityName.'</mark>', $text);
                        break;
                    case 'Marker':
                        $alert="entra en Marker";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="marker">'.$entityName.'</mark>', $text);
                        break;
                }
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
        //ld($abstract);
        //ld($entityBackup);
        $em=$this->doctrine->getManager();
        //We need all the entities involved in the same document
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
                switch ($qualifier) {
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
                    case 'CompoundNer':
                        $alert="entra en CompoundNer";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="compound">'.$entityName.'</mark>', $text);
                        break;
                    case 'CompoundMesh':
                        $alert="entra en CompoundMesh";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="compound">'.$entityName.'</mark>', $text);
                        break;
                    case 'Enzyme':
                        $alert="entra en Enzyme ";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="enzyme">'.$entityName.'</mark>', $text);
                        break;
                    case 'EnzymeMesh':
                        $alert="entra en EnzymeMesh";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="enzyme">'.$entityName.'</mark>', $text);
                        break;
                    case 'EnzymeDict':
                        $alert="entra en EnzymeDict";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="enzyme">'.$entityName.'</mark>', $text);
                        break;
                    case 'Protein':
                        $alert="entra en Protein";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="protein">'.$entityName.'</mark>', $text);
                        break;
                    case 'Cyp' :
                        $alert="entra en Cyp";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="cyp">'.$entityName.'</mark>', $text);
                        break;
                    case 'CypDict':
                        $alert="entra en CypDict";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="cyp">'.$entityName.'</mark>', $text);
                        break;
                    case 'CypRuleBased':
                        $alert="entra en CypRuleBased";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="cyp">'.$entityName.'</mark>', $text);
                        break;
                    case 'Mutation':
                        $alert="entra en Mutation";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="mutation">'.$entityName.'</mark>', $text);
                        break;
                    case 'GoTerm':
                        $alert="entra en GoTerm";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="go_term">'.$entityName.'</mark>', $text);
                        break;
                    case 'Keyword':
                        $alert="entra en Keyword";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="keyword">'.$entityName.'</mark>', $text);
                        break;
                    case 'Marker':
                        $alert="entra en Marker";
                        //ld($alert);
                        $text = str_ireplace($entityName, '<mark class="marker">'.$entityName.'</mark>', $text);
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