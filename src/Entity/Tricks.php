<?php

namespace App\Entity;

use App\Repository\TricksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TricksRepository::class)]
class Tricks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $editedAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'trickId', targetEntity: TrickMultimedia::class, orphanRemoval: true)]
    private $trickMultimedia;

    #[ORM\OneToMany(mappedBy: 'trickId', targetEntity: Commentary::class, orphanRemoval: true)]
    private $commentaries;

    public function __construct()
    {
        $this->trickMultimedia = new ArrayCollection();
        $this->commentaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getEditedAt(): ?\DateTimeImmutable
    {
        return $this->editedAt;
    }

    public function setEditedAt(\DateTimeImmutable $editedAt): self
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, TrickMultimedia>
     */
    public function getTrickMultimedia(): Collection
    {
        return $this->trickMultimedia;
    }

    public function addTrickMultimedia(TrickMultimedia $trickMultimedia): self
    {
        if (!$this->trickMultimedia->contains($trickMultimedia)) {
            $this->trickMultimedia[] = $trickMultimedia;
            $trickMultimedia->setTrickId($this);
        }

        return $this;
    }

    public function removeTrickMultimedia(TrickMultimedia $trickMultimedia): self
    {
        if ($this->trickMultimedia->removeElement($trickMultimedia)) {
            // set the owning side to null (unless already changed)
            if ($trickMultimedia->getTrickId() === $this) {
                $trickMultimedia->setTrickId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentary>
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentary $commentary): self
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries[] = $commentary;
            $commentary->setTrickId($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->commentaries->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getTrickId() === $this) {
                $commentary->setTrickId(null);
            }
        }

        return $this;
    }
}
