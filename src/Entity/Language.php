<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
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
     * @ORM\OneToMany(targetEntity=Test::class, mappedBy="language")
     */
    private $tests;

    /**
     * @ORM\OneToMany(targetEntity=UserTest::class, mappedBy="language")
     */
    private $userTests;

    /**
     * @ORM\ManyToMany(targetEntity=Olymp::class, mappedBy="languages")
     */
    private $olymps;


    public function __construct()
    {
        $this->tests = new ArrayCollection();
        $this->userTests = new ArrayCollection();
        $this->olymps = new ArrayCollection();
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
     * @return Collection|Test[]
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
            $test->setLanguage($this);
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        if ($this->tests->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getLanguage() === $this) {
                $test->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserTest[]
     */
    public function getUserTests(): Collection
    {
        return $this->userTests;
    }

    public function addUserTest(UserTest $userTest): self
    {
        if (!$this->userTests->contains($userTest)) {
            $this->userTests[] = $userTest;
            $userTest->setLanguage($this);
        }

        return $this;
    }

    public function removeUserTest(UserTest $userTest): self
    {
        if ($this->userTests->removeElement($userTest)) {
            // set the owning side to null (unless already changed)
            if ($userTest->getLanguage() === $this) {
                $userTest->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Olymp[]
     */
    public function getOlymps(): Collection
    {
        return $this->olymps;
    }

    public function addOlymp(Olymp $olymp): self
    {
        if (!$this->olymps->contains($olymp)) {
            $this->olymps[] = $olymp;
            $olymp->addLanguage($this);
        }

        return $this;
    }

    public function removeOlymp(Olymp $olymp): self
    {
        if ($this->olymps->removeElement($olymp)) {
            $olymp->removeLanguage($this);
        }

        return $this;
    }
}
