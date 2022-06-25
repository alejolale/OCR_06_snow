<?php

namespace App\Entity;

use App\Repository\TrickMultimediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrickMultimediaRepository::class)]
class TrickMultimedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'blob')]
    private $source;

    #[ORM\ManyToOne(targetEntity: Tricks::class, inversedBy: 'trickMultimedia')]
    #[ORM\JoinColumn(nullable: false)]
    private $trickId;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    public function __construct()
    {
        $this->trick = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return Collection<int, Tricks>
     */
    public function getTrick(): Collection
    {
        return $this->trick;
    }

    public function getTrickId(): ?Tricks
    {
        return $this->trickId;
    }

    public function setTrickId(?Tricks $trickId): self
    {
        $this->trickId = $trickId;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
