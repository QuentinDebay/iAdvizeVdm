<?php

namespace IAdvize\VdmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vdm
 *
 * @ORM\Table(name="vdm")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="IAdvize\VdmBundle\Entity\VdmRepository")
 */
class Vdm
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="vdmId", type="integer", nullable=true)
     */
    private $vdmId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255, nullable=true)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=100, nullable=true)
     */
    private $auteur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateP", type="date", nullable=true)
     */
    private $datep;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set vdmId
     *
     * @param string $vdmId
     * @return Vdm
     */
    public function setVdmId($vdmId)
    {
        $this->vdmId = $vdmId;

        return $this;
    }

    /**
     * Get vdmId
     *
     * @return string 
     */
    public function getVdmId()
    {
        return $this->vdmId;
    }
    
    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Vdm
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Vdm
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
     * Set datep
     *
     * @param \DateTime $datep
     * @return Vdm
     */
    public function setDatep($datep)
    {
        $this->datep = $datep;

        return $this;
    }

    /**
     * Get datep
     *
     * @return \DateTime 
     */
    public function getDatep()
    {
        return $this->datep;
    }
}
