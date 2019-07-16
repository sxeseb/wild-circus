<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriceRepository")
 */
class Price
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
     * @ORM\Column(type="float")
     */
    private $priceWeek;

    /**
     * @ORM\Column(type="float")
     */
    private $priceWeekEnd;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="price")
     */
    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
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

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setPrice($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getPrice() === $this) {
                $ticket->setPrice(null);
            }
        }

        return $this;
    }

    public function getPriceWeek(): ?float
    {
        return $this->priceWeek;
    }

    public function setPriceWeek(float $priceWeek): self
    {
        $this->priceWeek = $priceWeek;

        return $this;
    }

    public function getPriceWeekEnd(): ?float
    {
        return $this->priceWeekEnd;
    }

    public function setPriceWeekEnd(float $priceWeekEnd): self
    {
        $this->priceWeekEnd = $priceWeekEnd;

        return $this;
    }
}
