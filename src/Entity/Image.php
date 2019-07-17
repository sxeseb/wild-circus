<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $src;

    /**
     * @ORM\ManyToMany(targetEntity="Spectacle", mappedBy="image")
     */
    private $shows;

    public function __construct()
    {
        $this->shows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    /**
     * @return Collection|Spectacle[]
     */
    public function getShows(): Collection
    {
        return $this->shows;
    }

    public function addShow(Spectacle $show): self
    {
        if (!$this->shows->contains($show)) {
            $this->shows[] = $show;
            $show->addImage($this);
        }

        return $this;
    }

    public function removeShow(Spectacle $show): self
    {
        if ($this->shows->contains($show)) {
            $this->shows->removeElement($show);
            $show->removeImage($this);
        }

        return $this;
    }
}
