<?php


namespace AppBundle\Utils;


use AppBundle\Entity\Album;
use Doctrine\ORM\EntityManager;

class Label
{
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Augmentation du nombre de pistes de l'album
     *
     * @param $albumID
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function increasePiste($albumID)
    {
        $album = $this->em->getRepository('AppBundle:Album')->findOneBy(['id'=>$albumID]);

        if ($album){
            $album->setPiste($album->getPiste() + 1);
            $this->em->persist($album);
            $this->em->flush();

            return true;
        }else {
            return false;
        }
    }

    /**
     * Reduction du nombre de piste de l'album
     *
     * @param $albumID
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function decreasePiste($albumID)
    {
        $album = $this->em->getRepository('AppBundle:Album')->findOneBy(['id'=>$albumID]);
        if ($album){
            $album->setPiste($album->getPiste() - 1);
            $this->em->persist($album);
            $this->em->flush();

            return true;
        } else{
            return false;
        }
    }

    /**
     * Augmentation du nombre d'oeuvre a l'artiste
     *
     * @param $artisteID
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function increaseAlbum($artisteID)
    {
        $artiste = $this->em->getRepository('AppBundle:Artiste')->findOneBy(['id'=>$artisteID]);
        if ($artiste){
            $artiste->setOeuvre($artiste->getOeuvre() + 1);
            $this->em->persist($artiste);
            $this->em->flush($artiste);

            return true;
        } else{
            return false;
        }
    }

    /**
     * Reduction du nombre d'album de l'artiste
     *
     * @param $artisteID
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function decreaseAlbum($artisteID)
    {
        $artiste = $this->em->getRepository('AppBundle:Artiste')->findOneBy(['id'=>$artisteID]);
        if ($artiste){
            $artiste->setOeuvre($artiste->getOeuvre() - 1);
            $this->em->persist($artiste);
            $this->em->flush($artiste);

            return true;
        } else{
            return false;
        }
    }
}
