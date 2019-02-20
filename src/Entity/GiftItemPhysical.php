<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftItemPhysicalRepository")
 */
class GiftItemPhysical implements GiftItemInterface
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
     * @ORM\OneToOne(targetEntity="App\Entity\Gift", mappedBy="physical", cascade={"persist", "remove"})
     */
    private $gift;

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

    public function getGift(): ?Gift
    {
        return $this->gift;
    }

    public function setGift(Gift $gift): self
    {
        $this->gift = $gift;

        // set the owning side of the relation if necessary
        if ($this !== $gift->getPhysical()) {
            $gift->setPhysical($this);
        }

        return $this;
    }

    public function getReadable()
    {
        return $this->name;
    }
}
