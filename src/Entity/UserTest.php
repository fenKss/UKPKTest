<?php

namespace App\Entity;

use App\Repository\UserTestRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserTestRepository::class)
 */
class UserTest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userTests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="userTests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="userTests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $test;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $resultJson;

    /**
     * @ORM\Column(type="datetime")
     */
    private $resultSavedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Variant::class, inversedBy="userTests")
     */
    private $variant;

    public function __construct()
    {
        $this->setResultSavedAt(new Carbon());
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getResultJson(): ?string
    {
        return $this->resultJson;
    }

    public function setResultJson(?string $resultJson): self
    {
        $this->resultJson = $resultJson;

        return $this;
    }

    public function getResultSavedAt(): ?\DateTimeInterface
    {
        return $this->resultSavedAt;
    }

    public function setResultSavedAt(\DateTimeInterface $resultSavedAt): self
    {
        $this->resultSavedAt = $resultSavedAt;

        return $this;
    }

    public function getVariant(): ?Variant
    {
        return $this->variant;
    }

    public function setVariant(?Variant $variant): self
    {
        $this->variant = $variant;

        return $this;
    }
}
