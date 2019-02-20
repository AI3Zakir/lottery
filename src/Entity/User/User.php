<?php

namespace App\Entity\User;

use App\Entity\Gift;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use MsgPhp\User\Entity\User as BaseUser;
use MsgPhp\User\UserIdInterface;
use MsgPhp\Domain\Event\DomainEventHandlerInterface;
use MsgPhp\Domain\Event\DomainEventHandlerTrait;
use MsgPhp\User\Entity\Credential\EmailPassword;
use MsgPhp\User\Entity\Features\EmailPasswordCredential;
use MsgPhp\User\Entity\Fields\RolesField;

/**
 * @ORM\Entity()
 */
class User extends BaseUser implements DomainEventHandlerInterface
{
    use DomainEventHandlerTrait;
    use EmailPasswordCredential;
    use RolesField;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="msgphp_user_id", length=191)
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gift", mappedBy="user", orphanRemoval=true)
     */
    private $gifts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="float", options={"default": 0 })
     */
    private $loyaltyBalance;

    public function __construct(UserIdInterface $id, string $email, string $password, string $firstName, string $lastName, $loyaltyBalance = 0)
    {
        $this->id = $id;
        $this->credential = new EmailPassword($email, $password);
        $this->gifts = new ArrayCollection();
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->loyaltyBalance = $loyaltyBalance;
    }

    public function getId(): UserIdInterface
    {
        return $this->id;
    }

    /**
     * @return Collection|Gift[]
     */
    public function getGifts(): Collection
    {
        return $this->gifts;
    }

    public function addGift(Gift $gift): self
    {
        if (!$this->gifts->contains($gift)) {
            $this->gifts[] = $gift;
            $gift->setUser($this);
        }

        return $this;
    }

    public function removeGift(Gift $gift): self
    {
        if ($this->gifts->contains($gift)) {
            $this->gifts->removeElement($gift);
            // set the owning side to null (unless already changed)
            if ($gift->getUser() === $this) {
                $gift->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLoyaltyBalance(): ?float
    {
        return $this->loyaltyBalance;
    }

    public function setLoyaltyBalance(float $loyaltyBalance): self
    {
        $this->loyaltyBalance = $loyaltyBalance;

        return $this;
    }
}
