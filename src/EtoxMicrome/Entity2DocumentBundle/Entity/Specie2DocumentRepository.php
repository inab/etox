<?php

namespace EtoxMicrome\Entity2DocumentBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Specie2DocumentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Specie2DocumentRepository extends EntityRepository
{
    public function getBetterRanked($arraycytochromes){
        $message="Inside getBetterRanked";
        usort($arraycytochromes, function($cyt1,$cyt2){
            $message="Inside usort cmp";
            $ranking1=$cyt1->getCypUniprotRanking();
            $ranking2=$cyt2->getCypUniprotRanking();
            if ($ranking1 == $ranking2) {
                return 0;
            }
            return ($ranking1 > $ranking2) ? -1 : 1;
        });
        return $arraycytochromes;
    }

}
