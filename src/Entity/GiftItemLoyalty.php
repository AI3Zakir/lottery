<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftItemLoyaltyRepository")
 */
class GiftItemLoyalty implements GiftItemInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Gift", mappedBy="loyalty", cascade={"persist", "remove"})
     */
    private $gift;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getGift(): ?Gift
    {
        return $this->gift;
    }

    public function setGift(Gift $gift): self
    {
        $this->gift = $gift;

        // set the owning side of the relation if necessary
        if ($this !== $gift->getLoyalty()) {
            $gift->setLoyalty($this);
        }

        return $this;
    }

    public function getReadable()
    {
        return $this->amount . ' Points';
    }
}
