<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

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
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\OneToMany(targetEntity=Test::class, mappedBy="language")
     */
    private Collection $tests;

    /**
     * @ORM\OneToMany(targetEntity=UserTest::class, mappedBy="language")
     */
    private Collection $userTests;

    /**
     * @ORM\ManyToMany(targetEntity=Olympic::class, mappedBy="languages")
     */
    private Collection $olympics;


    public function __construct()
    {
        $this->tests = new ArrayCollection();
        $this->userTests = new ArrayCollection();
        $this->olympics = new ArrayCollection();
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
     * @return Collection|Olympic[]
     */
    public function getOlympics(): Collection
    {
        return $this->olympics;
    }

    public function addOlympic(Olympic $olympic): self
    {
        if (!$this->olympics->contains($olympic)) {
            $this->olympics[] = $olympic;
            $olympic->addLanguage($this);
        }

        return $this;
    }

    public function removeOlympic(Olympic $olympic): self
    {
        if ($this->olympics->removeElement($olympic)) {
            $olympic->removeLanguage($this);
        }

        return $this;
    }
}
