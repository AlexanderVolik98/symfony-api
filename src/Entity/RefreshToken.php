<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshTokenRepository;
use Gesdinet\JWTRefreshTokenBundle\Model\AbstractRefreshToken;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=RefreshTokenRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class RefreshToken extends AbstractRefreshToken
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $refreshToken;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $username;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $valid;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private UserInterface $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeInterface $createdAt;

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $dt): self
    {
        $this->createdAt = $dt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = (new \DateTimeImmutable());
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Creates a new model instance based on the provided details (overridden).
     */
    public static function createForUserWithTtl(string $refreshToken, UserInterface $user, int $ttl): RefreshTokenInterface
    {
        /** @var RefreshToken $entity */
        $entity = parent::createForUserWithTtl($refreshToken, $user, $ttl);
        $entity->setUser($user);

        return $entity;
    }
}
