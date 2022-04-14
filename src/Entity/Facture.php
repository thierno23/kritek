<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateFacture;

    #[ORM\Column(type: 'integer')]
    private $numberInvoce;

    #[ORM\Column(type: 'integer')]
    private $customerId;

    #[ORM\OneToMany(mappedBy: 'invoce', targetEntity: Invocelines::class, cascade: ["persist"])]
    private $invocelines;

    public function __construct()
    {
        $this->invocelines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateFacture(): ?\DateTimeInterface
    {
        return $this->dateFacture;
    }

    public function setDateFacture(\DateTimeInterface $dateFacture): self
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }

    public function getNumberInvoce(): ?int
    {
        return $this->numberInvoce;
    }

    public function setNumberInvoce(int $numberInvoce): self
    {
        $this->numberInvoce = $numberInvoce;

        return $this;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @return Collection<int, Invocelines>
     */
    public function getInvocelines(): Collection
    {
        return $this->invocelines;
    }

    public function addInvoceline(Invocelines $invoceline): self
    {
        if (!$this->invocelines->contains($invoceline)) {
            $this->invocelines[] = $invoceline;
            $invoceline->setInvoce($this);
        }

        return $this;
    }

    public function removeInvoceline(Invocelines $invoceline): self
    {
        if ($this->invocelines->removeElement($invoceline)) {
            // set the owning side to null (unless already changed)
            if ($invoceline->getInvoce() === $this) {
                $invoceline->setInvoce(null);
            }
        }

        return $this;
    }
}
