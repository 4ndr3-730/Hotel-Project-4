<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]
class Chambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $DescriptionCourte = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $DescriptionLongue = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(length: 4)]
    private ?string $PrixJournalier = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $UpdatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DeletedAt = null;

    #[ORM\OneToMany(mappedBy: 'chambre', targetEntity: Commande::class)]
    private Collection $chambre_id;

    public function __construct()
    {
        $this->chambre_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescriptionCourte(): ?string
    {
        return $this->DescriptionCourte;
    }

    public function setDescriptionCourte(string $DescriptionCourte): self
    {
        $this->DescriptionCourte = $DescriptionCourte;

        return $this;
    }

    public function getDescriptionLongue(): ?string
    {
        return $this->DescriptionLongue;
    }

    public function setDescriptionLongue(string $DescriptionLongue): self
    {
        $this->DescriptionLongue = $DescriptionLongue;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrixJournalier(): ?string
    {
        return $this->PrixJournalier;
    }

    public function setPrixJournalier(string $PrixJournalier): self
    {
        $this->PrixJournalier = $PrixJournalier;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->DeletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $DeletedAt): self
    {
        $this->DeletedAt = $DeletedAt;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getChambreId(): Collection
    {
        return $this->chambre_id;
    }

    public function addChambreId(Commande $chambreId): self
    {
        if (!$this->chambre_id->contains($chambreId)) {
            $this->chambre_id->add($chambreId);
            $chambreId->setChambre($this);
        }

        return $this;
    }

    public function removeChambreId(Commande $chambreId): self
    {
        if ($this->chambre_id->removeElement($chambreId)) {
            // set the owning side to null (unless already changed)
            if ($chambreId->getChambre() === $this) {
                $chambreId->setChambre(null);
            }
        }

        return $this;
    }
}
