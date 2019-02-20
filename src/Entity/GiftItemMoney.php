<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftItemMoneyRepository")
 */
class GiftItemMoney implements GiftItemInterface
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
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $converted;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Gift", mappedBy="money", cascade={"persist", "remove"})
     */
    private $gift;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $transferred;

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

    public function getConverted(): ?bool
    {
        return $this->converted;
    }

    public function setConverted(bool $converted): self
    {
        $this->converted = $converted;

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
        if ($this !== $gift->getMoney()) {
            $gift->setMoney($this);
        }

        return $this;
    }

    public function getReadable()
    {
        return $this->amount . '$';
    }

    public function getTransferred(): ?bool
    {
        return $this->transferred;
    }

    public function setTransferred(bool $transferred): self
    {
        $this->transferred = $transferred;

        return $this;
    }
}
