<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=AccessToken::class, mappedBy="user")
     */
    private $accessTokens;

    /**
     * @ORM\OneToMany(targetEntity=RefreshToken::class, mappedBy="user")
     */
    private $refreshTokens;

    /**
     * @ORM\OneToMany(targetEntity=AuthCode::class, mappedBy="user")
     */
    private $authCodes;

    public function __construct()
    {
        $this->accessTokens = new ArrayCollection();
        $this->refreshTokens = new ArrayCollection();
        $this->authCodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $accessToken->setUser($this);
        }

        return $this;
    }

    public function removeAccessToken(AccessToken $accessToken): self
    {
        if ($this->accessTokens->removeElement($accessToken)) {
            // set the owning side to null (unless already changed)
            if ($accessToken->getUser() === $this) {
                $accessToken->setUser(null);
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
            $refreshToken->setUser($this);
        }

        return $this;
    }

    public function removeRefreshToken(RefreshToken $refreshToken): self
    {
        if ($this->refreshTokens->removeElement($refreshToken)) {
            // set the owning side to null (unless already changed)
            if ($refreshToken->getUser() === $this) {
                $refreshToken->setUser(null);
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
            $authCode->setUser($this);
        }

        return $this;
    }

    public function removeAuthCode(AuthCode $authCode): self
    {
        if ($this->authCodes->removeElement($authCode)) {
            // set the owning side to null (unless already changed)
            if ($authCode->getUser() === $this) {
                $authCode->setUser(null);
            }
        }

        return $this;
    }
}
