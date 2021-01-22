<?php 

namespace App\Entity;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Validator\Constraints as Assert;

class FiltreSortie
{
    /**
     * @var integer|null
     */
    private $idUser;
    
    /**
     * @var string|null
     */
    private $campus;

    /**
     * @var string|null
     */
    private $nomSortie;

    /**
     * @var \DateTimeInterface|null
     * @Assert\LessThanOrEqual(propertyPath="finDate", message="doit être avant la date de fin")
     */
    private $debutDate;

    /**
     * @var \DateTimeInterface|null
     * @Assert\GreaterThanOrEqual(propertyPath="debutDate", message="doit être après la date de début")
     */
    private $finDate;

    /**
     * @var Boolean|null
     */
    private $sortieOrganisateur;

    /**
     * @var Boolean|null
     */
    private $sortieInscrit;

    /**
     * @var Boolean|null
     */
    private $sortiePasInscrit;

    /**
     * @var Boolean|null
     */
    private $sortiePassee;

    public function __construct(){}

 
    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * Get the value of nomSortie
     * @return  string|null
     */ 
    public function getNomSortie()
    {
        return $this->nomSortie;
    }

    /**
     * Set the value of nomSortie
     * @param  string|null  $nomSortie
     * @return  self
     */ 
    public function setNomSortie($nomSortie)
    {
        $this->nomSortie = $nomSortie;
        return $this;
    }

    /**
     * Get the value of debutDate
     * @return  \DateTimeInterface|null
     */ 
    public function getDebutDate()
    {
        return $this->debutDate;
    }

    /**
     * Set the value of debutDate
     * @param  \DateTimeInterface|null  $debutDate
     * @return  self
     */ 
    public function setDebutDate($debutDate)
    {
        $this->debutDate = $debutDate;
        return $this;
    }

    /**
     * Get the value of finDate
     * @return  \DateTimeInterface|null
     */ 
    public function getFinDate()
    {
        return $this->finDate;
    }

    /**
     * Set the value of finDate
     * @param  \DateTimeInterface|null  $finDate
     * @return  self
     */ 
    public function setFinDate($finDate)
    {
        $this->finDate = $finDate;
        return $this;
    }

    /**
     * Get the value of sortieOrganisateur
     * @return  Boolean|null
     */ 
    public function getSortieOrganisateur()
    {
        return $this->sortieOrganisateur;
    }

    /**
     * Set the value of sortieOrganisateur
     * @param  Boolean|null  $sortieOrganisateur
     * @return  self
     */ 
    public function setSortieOrganisateur($sortieOrganisateur)
    {
        $this->sortieOrganisateur = $sortieOrganisateur;
        return $this;
    }

    /**
     * Get the value of sortieInscrit
     * @return  Boolean|null
     */ 
    public function getSortieInscrit()
    {
        return $this->sortieInscrit;
    }

    /**
     * Set the value of sortieInscrit
     * @param  Boolean|null  $sortieInscrit
     * @return  self
     */ 
    public function setSortieInscrit($sortieInscrit)
    {
        $this->sortieInscrit = $sortieInscrit;
        return $this;
    }

    /**
     * Get the value of sortiePasInscrit
     * @return  Boolean|null
     */ 
    public function getSortiePasInscrit()
    {
        return $this->sortiePasInscrit;
    }

    /**
     * Set the value of sortiePasInscrit
     * @param  Boolean|null  $sortiePasInscrit
     * @return  self
     */ 
    public function setSortiePasInscrit($sortiePasInscrit)
    {
        $this->sortiePasInscrit = $sortiePasInscrit;
        return $this;
    }

    /**
     * Get the value of sortiePassée
     * @return  Boolean|null
     */ 
    public function getSortiePassee()
    {
        return $this->sortiePassee;
    }

    /**
     * Set the value of sortiePassée
     * @param  Boolean|null  $sortiePassée
     * @return  self
     */ 
    public function setSortiePassee($sortiePassee)
    {
        $this->sortiePassee = $sortiePassee;
        return $this;
    }

    /**
     * @return  integer|null
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param  integer|null  $idUser
     * @return  self
     */ 
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }
}