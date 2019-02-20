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

    public function __construct(UserIdInterface $id, string $email, string $password)
    {
        $this->id = $id;
        $this->credential = new EmailPassword($email, $password);
        $this->gifts = new ArrayCollection();
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
}
