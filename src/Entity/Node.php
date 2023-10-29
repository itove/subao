<?php

namespace App\Entity;

use App\Repository\NodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NodeRepository::class)]
class Node
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    #[ORM\ManyToOne(inversedBy: 'nodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Firm $firm = null;

    #[ORM\ManyToOne(inversedBy: 'nodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $lawyer = null;

    #[ORM\Column(length: 255)]
    private ?string $application = null;

    #[ORM\OneToMany(mappedBy: 'node', targetEntity: Others::class)]
    private Collection $others;

    public function __construct()
    {
        $this->others = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getFirm(): ?Firm
    {
        return $this->firm;
    }

    public function setFirm(?Firm $firm): static
    {
        $this->firm = $firm;

        return $this;
    }

    public function getLawyer(): ?User
    {
        return $this->lawyer;
    }

    public function setLawyer(?User $lawyer): static
    {
        $this->lawyer = $lawyer;

        return $this;
    }

    public function getApplication(): ?string
    {
        return $this->application;
    }

    public function setApplication(string $application): static
    {
        $this->application = $application;

        return $this;
    }

    /**
     * @return Collection<int, Others>
     */
    public function getOthers(): Collection
    {
        return $this->others;
    }

    public function addOther(Others $other): static
    {
        if (!$this->others->contains($other)) {
            $this->others->add($other);
            $other->setNode($this);
        }

        return $this;
    }

    public function removeOther(Others $other): static
    {
        if ($this->others->removeElement($other)) {
            // set the owning side to null (unless already changed)
            if ($other->getNode() === $this) {
                $other->setNode(null);
            }
        }

        return $this;
    }
}