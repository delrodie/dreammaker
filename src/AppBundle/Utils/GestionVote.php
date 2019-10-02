<?php


namespace AppBundle\Utils;


use Doctrine\ORM\EntityManager;

class GestionVote
{
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Ajout du vote au candidat
     */
    public function vote($slug, $web=null, $fbk=null, $sms=null)
    {
        $candidat = $this->em->getRepository("AppBundle:Candidat")->findOneBy(['slug'=>$slug]);

        // Si web existe alors recuperer les autres valeurs de la table
        // sinon considerer les valeurs transmises
        if ($web){
            $pointFbk = $candidat->getPointFacebook()+$fbk;
            $pointWeb = $candidat->getPointWeb()+$web;
            $pointSMS = $candidat->getPointUreport()+$sms;
            $total = $pointFbk+$pointWeb+$pointSMS;
        }else{
            $pointWeb = $candidat->getPointWeb();
            $total = $fbk+$sms+$pointWeb;
        }

        $candidat->setPointFacebook($fbk);
        $candidat->setPointWeb($pointWeb);
        $candidat->setPointUreport($sms);
        $candidat->setTotal($total);
        $this->em->persist($candidat);
        $this->em->flush();

        return true;
    }
}
