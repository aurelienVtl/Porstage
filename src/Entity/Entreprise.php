<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
	 *	@Assert\NotBlank
	 * 	@Assert\Length(
	 *	max = 254,
	 *  min = 4,
	 *	minMessage = " Le tritre doit faire minimum {{ limit }} characteres",
	 *	maxMessage = " Le titre doit faire max {{ limit }} characteres "
	 * )
     */
    private $nom;

    /**
     * 	@ORM\Column(type="string", length=255)
	 * 	@Assert\Regex(pattern="# (rue|avenue|boulevard|impasse|voie) #i", 
						message="le type de route/voie semble incorrect");
	 *	@Assert\Regex(pattern="# [0-9]{5} ?#", message="probleme avec le code postale");
	 *	@Assert\Regex(pattern="# [1-999] ?(bis)?#", message="probleme avec le numero de rue"); 
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
	 * @Assert\Url
     */
    private $urlSite;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise", orphanRemoval=true)
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getUrlSite(): ?string
    {
        return $this->urlSite;
    }

    public function setUrlSite(?string $urlSite): self
    {
        $this->urlSite = $urlSite;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }
}
