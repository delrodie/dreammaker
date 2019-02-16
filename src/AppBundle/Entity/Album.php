<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Album
 *
 * @ORM\Table(name="album")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlbumRepository")
 * @Vich\Uploadable
 */
class Album
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="piste", type="string", length=255, nullable=true, options={"default": 0})
     */
    private $piste;

    /**
     * @var string
     *
     * @ORM\Column(name="compositeur", type="string", length=255, nullable=true)
     */
    private $compositeur;

    /**
     * @var string
     *
     * @ORM\Column(name="choeur", type="string", length=255, nullable=true)
     */
    private $choeur;

    /**
     * @var string
     *
     * @ORM\Column(name="arrangeur", type="string", length=255, nullable=true)
     */
    private $arrangeur;

    /**
     * @var string
     *
     * @ORM\Column(name="producteur", type="string", length=255, nullable=true)
     */
    private $producteur;

    /**
     * @var string
     *
     * @ORM\Column(name="mixage", type="string", length=255, nullable=true)
     */
    private $mixage;

    /**
     * @var string
     *
     * @ORM\Column(name="master", type="string", length=255, nullable=true)
     */
    private $master;

    /**
     * @var string
     *
     * @ORM\Column(name="distribution", type="string", length=255, nullable=true)
     */
    private $distribution;

    /**
     * @var string
     *
     * @ORM\Column(name="spotify", type="string", length=255, nullable=true)
     */
    private $spotify;

    /**
     * @var string
     *
     * @ORM\Column(name="deezer", type="string", length=255, nullable=true)
     */
    private $deezer;

    /**
     * @var string
     *
     * @ORM\Column(name="itunes", type="string", length=255, nullable=true)
     */
    private $itunes;

    /**
     * @var string
     *
     * @ORM\Column(name="googlePlay", type="string", length=255, nullable=true)
     */
    private $googlePlay;

    /**
     * @var string
     *
     * @ORM\Column(name="amazon", type="string", length=255, nullable=true)
     */
    private $amazon;

    /**
     * @var string
     *
     * @ORM\Column(name="iftypay", type="string", length=255, nullable=true)
     */
    private $iftypay;

    /**
     * @var bool
     *
     * @ORM\Column(name="statut", type="boolean", nullable=true)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Artiste", inversedBy="albums")
     * @ORM\JoinColumn(name="artiste_id", referencedColumnName="id")
     */
    private $artiste;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Chanson", mappedBy="album")
     */
    private $pistes;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="album_image", fileNameProperty="imageName", size="imageSize", nullable=true)
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\Column(name="publie_par", type="string", length=25, nullable=true)
     */
    private $publiePar;

    /**
     * @var string
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\Column(name="modifie_par", type="string", length=25, nullable=true)
     */
    private $modifiePar;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="publie_le", type="datetimetz", nullable=true)
     */
    private $publieLe;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="modifie_le", type="datetimetz", nullable=true)
     */
    private $modifieLe;

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Album
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Album
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Album
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Album
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set compositeur
     *
     * @param string $compositeur
     *
     * @return Album
     */
    public function setCompositeur($compositeur)
    {
        $this->compositeur = $compositeur;

        return $this;
    }

    /**
     * Get compositeur
     *
     * @return string
     */
    public function getCompositeur()
    {
        return $this->compositeur;
    }

    /**
     * Set choeur
     *
     * @param string $choeur
     *
     * @return Album
     */
    public function setChoeur($choeur)
    {
        $this->choeur = $choeur;

        return $this;
    }

    /**
     * Get choeur
     *
     * @return string
     */
    public function getChoeur()
    {
        return $this->choeur;
    }

    /**
     * Set arrangeur
     *
     * @param string $arrangeur
     *
     * @return Album
     */
    public function setArrangeur($arrangeur)
    {
        $this->arrangeur = $arrangeur;

        return $this;
    }

    /**
     * Get arrangeur
     *
     * @return string
     */
    public function getArrangeur()
    {
        return $this->arrangeur;
    }

    /**
     * Set producteur
     *
     * @param string $producteur
     *
     * @return Album
     */
    public function setProducteur($producteur)
    {
        $this->producteur = $producteur;

        return $this;
    }

    /**
     * Get producteur
     *
     * @return string
     */
    public function getProducteur()
    {
        return $this->producteur;
    }

    /**
     * Set mixage
     *
     * @param string $mixage
     *
     * @return Album
     */
    public function setMixage($mixage)
    {
        $this->mixage = $mixage;

        return $this;
    }

    /**
     * Get mixage
     *
     * @return string
     */
    public function getMixage()
    {
        return $this->mixage;
    }

    /**
     * Set master
     *
     * @param string $master
     *
     * @return Album
     */
    public function setMaster($master)
    {
        $this->master = $master;

        return $this;
    }

    /**
     * Get master
     *
     * @return string
     */
    public function getMaster()
    {
        return $this->master;
    }

    /**
     * Set distribution
     *
     * @param string $distribution
     *
     * @return Album
     */
    public function setDistribution($distribution)
    {
        $this->distribution = $distribution;

        return $this;
    }

    /**
     * Get distribution
     *
     * @return string
     */
    public function getDistribution()
    {
        return $this->distribution;
    }

    /**
     * Set spotify
     *
     * @param string $spotify
     *
     * @return Album
     */
    public function setSpotify($spotify)
    {
        $this->spotify = $spotify;

        return $this;
    }

    /**
     * Get spotify
     *
     * @return string
     */
    public function getSpotify()
    {
        return $this->spotify;
    }

    /**
     * Set deezer
     *
     * @param string $deezer
     *
     * @return Album
     */
    public function setDeezer($deezer)
    {
        $this->deezer = $deezer;

        return $this;
    }

    /**
     * Get deezer
     *
     * @return string
     */
    public function getDeezer()
    {
        return $this->deezer;
    }

    /**
     * Set itunes
     *
     * @param string $itunes
     *
     * @return Album
     */
    public function setItunes($itunes)
    {
        $this->itunes = $itunes;

        return $this;
    }

    /**
     * Get itunes
     *
     * @return string
     */
    public function getItunes()
    {
        return $this->itunes;
    }

    /**
     * Set googlePlay
     *
     * @param string $googlePlay
     *
     * @return Album
     */
    public function setGooglePlay($googlePlay)
    {
        $this->googlePlay = $googlePlay;

        return $this;
    }

    /**
     * Get googlePlay
     *
     * @return string
     */
    public function getGooglePlay()
    {
        return $this->googlePlay;
    }

    /**
     * Set amazon
     *
     * @param string $amazon
     *
     * @return Album
     */
    public function setAmazon($amazon)
    {
        $this->amazon = $amazon;

        return $this;
    }

    /**
     * Get amazon
     *
     * @return string
     */
    public function getAmazon()
    {
        return $this->amazon;
    }

    /**
     * Set iftypay
     *
     * @param string $iftypay
     *
     * @return Album
     */
    public function setIftypay($iftypay)
    {
        $this->iftypay = $iftypay;

        return $this;
    }

    /**
     * Get iftypay
     *
     * @return string
     */
    public function getIftypay()
    {
        return $this->iftypay;
    }

    /**
     * Set statut
     *
     * @param boolean $statut
     *
     * @return Album
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return bool
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Album
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Album
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set imageSize
     *
     * @param integer $imageSize
     *
     * @return Album
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * Get imageSize
     *
     * @return integer
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Album
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set publiePar
     *
     * @param string $publiePar
     *
     * @return Album
     */
    public function setPubliePar($publiePar)
    {
        $this->publiePar = $publiePar;

        return $this;
    }

    /**
     * Get publiePar
     *
     * @return string
     */
    public function getPubliePar()
    {
        return $this->publiePar;
    }

    /**
     * Set modifiePar
     *
     * @param string $modifiePar
     *
     * @return Album
     */
    public function setModifiePar($modifiePar)
    {
        $this->modifiePar = $modifiePar;

        return $this;
    }

    /**
     * Get modifiePar
     *
     * @return string
     */
    public function getModifiePar()
    {
        return $this->modifiePar;
    }

    /**
     * Set publieLe
     *
     * @param \DateTime $publieLe
     *
     * @return Album
     */
    public function setPublieLe($publieLe)
    {
        $this->publieLe = $publieLe;

        return $this;
    }

    /**
     * Get publieLe
     *
     * @return \DateTime
     */
    public function getPublieLe()
    {
        return $this->publieLe;
    }

    /**
     * Set modifieLe
     *
     * @param \DateTime $modifieLe
     *
     * @return Album
     */
    public function setModifieLe($modifieLe)
    {
        $this->modifieLe = $modifieLe;

        return $this;
    }

    /**
     * Get modifieLe
     *
     * @return \DateTime
     */
    public function getModifieLe()
    {
        return $this->modifieLe;
    }

    /**
     * Set artiste
     *
     * @param \AppBundle\Entity\Artiste $artiste
     *
     * @return Album
     */
    public function setArtiste(\AppBundle\Entity\Artiste $artiste = null)
    {
        $this->artiste = $artiste;

        return $this;
    }

    /**
     * Get artiste
     *
     * @return \AppBundle\Entity\Artiste
     */
    public function getArtiste()
    {
        return $this->artiste;
    }

    /**
     * Set piste
     *
     * @param string $piste
     *
     * @return Album
     */
    public function setPiste($piste)
    {
        $this->piste = $piste;

        return $this;
    }

    /**
     * Get piste
     *
     * @return string
     */
    public function getPiste()
    {
        return $this->piste;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pistes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add piste
     *
     * @param \AppBundle\Entity\Chanson $piste
     *
     * @return Album
     */
    public function addPiste(\AppBundle\Entity\Chanson $piste)
    {
        $this->pistes[] = $piste;

        return $this;
    }

    /**
     * Remove piste
     *
     * @param \AppBundle\Entity\Chanson $piste
     */
    public function removePiste(\AppBundle\Entity\Chanson $piste)
    {
        $this->pistes->removeElement($piste);
    }

    /**
     * Get pistes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPistes()
    {
        return $this->pistes;
    }
}
