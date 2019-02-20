<?php

namespace App\Entity;

use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftRepository")
 */
class Gift
{
    const TYPE_MONEY = 0;
    const TYPE_LOYALTY_POINTS = 1;
    const TYPE_PHYSICAL = 2;

    const READABLE_TYPES = [
        self::TYPE_MONEY => 'Money',
        self::TYPE_LOYALTY_POINTS => 'Loyalty Points',
        self::TYPE_PHYSICAL => 'Physical Gift'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="gifts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    private $claimed = false;

    /**
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    private $rejected = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $physicalItem;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $loyaltyPoints;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $money;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getClaimed(): ?bool
    {
        return $this->claimed;
    }

    public function setClaimed(bool $claimed): self
    {
        $this->claimed = $claimed;

        return $this;
    }

    public function getRejected(): ?bool
    {
        return $this->rejected;
    }

    public function setRejected(bool $rejected): self
    {
        $this->rejected = $rejected;

        return $this;
    }

    public function getPhysicalItem(): ?string
    {
        return $this->physicalItem;
    }

    public function setPhysicalItem(?string $physicalItem): self
    {
        $this->physicalItem = $physicalItem;

        return $this;
    }

    public function getLoyaltyPoints(): ?float
    {
        return $this->loyaltyPoints;
    }

    public function setLoyaltyPoints(?float $loyaltyPoints): self
    {
        $this->loyaltyPoints = $loyaltyPoints;

        return $this;
    }

    public function getMoney(): ?float
    {
        return $this->money;
    }

    public function setMoney(?float $money): self
    {
        $this->money = $money;

        return $this;
    }
}
