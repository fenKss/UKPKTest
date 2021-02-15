<?php

namespace App\Entity;

use App\Repository\VariantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VariantRepository::class)
 */
class Variant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="variants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $test;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="variant")
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity=UserTest::class, mappedBy="variant")
     */
    private $userTests;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->userTests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $variantQuestion): self
    {
        if (!$this->questions->contains($variantQuestion)) {
            $this->questions[] = $variantQuestion;
            $variantQuestion->setVariant($this);
        }

        return $this;
    }

    public function removeQuestion(Question $variantQuestion): self
    {
        if ($this->questions->removeElement($variantQuestion)) {
            // set the owning si
            //de to null (unless already changed)
            if ($variantQuestion->getVariant() === $this) {
                $variantQuestion->setVariant(null);
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
            $userTest->setVariant($this);
        }

        return $this;
    }

    public function removeUserTest(UserTest $userTest): self
    {
        if ($this->userTests->removeElement($userTest)) {
            // set the owning side to null (unless already changed)
            if ($userTest->getVariant() === $this) {
                $userTest->setVariant(null);
            }
        }

        return $this;
    }
}
