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

    const PENDING = 0;
    const CLAIMED = 1;
    const REJECTED = 2;

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
     * @ORM\Column(type="smallint", options={"default": 0})
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\GiftItemLoyalty", inversedBy="gift", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $loyalty;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\GiftItemMoney", inversedBy="gift", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $money;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\GiftItemPhysical", inversedBy="gift", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $physical;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLoyalty(): ?GiftItemLoyalty
    {
        return $this->loyalty;
    }

    public function setLoyalty(GiftItemLoyalty $loyalty): self
    {
        $this->loyalty = $loyalty;

        return $this;
    }

    public function getMoney(): ?GiftItemMoney
    {
        return $this->money;
    }

    public function setMoney(GiftItemMoney $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getPhysical(): ?GiftItemPhysical
    {
        return $this->physical;
    }

    public function setPhysical(GiftItemPhysical $physical): self
    {
        $this->physical = $physical;

        return $this;
    }

    public function getItem(): GiftItemInterface
    {
        if ($this->type === self::TYPE_MONEY) {
            return $this->money;
        } elseif ($this->type === self::TYPE_LOYALTY_POINTS) {
            return $this->loyalty;
        } elseif ($this->type === self::TYPE_PHYSICAL) {
            return $this->physical;
        }
    }
}
