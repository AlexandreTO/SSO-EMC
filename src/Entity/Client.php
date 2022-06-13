<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=AccessToken::class, mappedBy="client")
     */
    private $accessTokens;

    /**
     * @ORM\OneToMany(targetEntity=RefreshToken::class, mappedBy="client")
     */
    private $refreshTokens;

    /**
     * @ORM\OneToMany(targetEntity=AuthCode::class, mappedBy="client")
     */
    private $authCodes;
    
    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->accessTokens = new ArrayCollection();
        $this->refreshTokens = new ArrayCollection();
        $this->authCodes = new ArrayCollection();
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
     * @return Collection<int, AccessToken>
     */
    public function getAccessTokens(): Collection
    {
        return $this->accessTokens;
    }

    public function addAccessToken(AccessToken $accessToken): self
    {
        if (!$this->accessTokens->contains($accessToken)) {
            $this->accessTokens[] = $accessToken;
            $accessToken->setClient($this);
        }

        return $this;
    }

    public function removeAccessToken(AccessToken $accessToken): self
    {
        if ($this->accessTokens->removeElement($accessToken)) {
            // set the owning side to null (unless already changed)
            if ($accessToken->getClient() === $this) {
                $accessToken->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RefreshToken>
     */
    public function getRefreshTokens(): Collection
    {
        return $this->refreshTokens;
    }

    public function addRefreshToken(RefreshToken $refreshToken): self
    {
        if (!$this->refreshTokens->contains($refreshToken)) {
            $this->refreshTokens[] = $refreshToken;
            $refreshToken->setClient($this);
        }

        return $this;
    }

    public function removeRefreshToken(RefreshToken $refreshToken): self
    {
        if ($this->refreshTokens->removeElement($refreshToken)) {
            // set the owning side to null (unless already changed)
            if ($refreshToken->getClient() === $this) {
                $refreshToken->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AuthCode>
     */
    public function getAuthCodes(): Collection
    {
        return $this->authCodes;
    }

    public function addAuthCode(AuthCode $authCode): self
    {
        if (!$this->authCodes->contains($authCode)) {
            $this->authCodes[] = $authCode;
            $authCode->setClient($this);
        }

        return $this;
    }

    public function removeAuthCode(AuthCode $authCode): self
    {
        if ($this->authCodes->removeElement($authCode)) {
            // set the owning side to null (unless already changed)
            if ($authCode->getClient() === $this) {
                $authCode->setClient(null);
            }
        }

        return $this;
    }
}
