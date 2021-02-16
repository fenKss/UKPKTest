<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Variant::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $variant;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=PossibleAnswer::class, mappedBy="question")
     */
    private $possibleAnswers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleType;

    public function __construct()
    {
        $this->possibleAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|PossibleAnswer[]
     */
    public function getPossibleAnswers(): Collection
    {
        return $this->possibleAnswers;
    }

    public function addPossibleAnswer(PossibleAnswer $questionOption): self
    {
        if (!$this->possibleAnswers->contains($questionOption)) {
            $this->possibleAnswers[] = $questionOption;
            $questionOption->setQuestion($this);
        }

        return $this;
    }

    public function removePossibleAnswer(PossibleAnswer $questionOption): self
    {
        if ($this->possibleAnswers->removeElement($questionOption)) {
            // set the owning side to null (unless already changed)
            if ($questionOption->getQuestion() === $this) {
                $questionOption->setQuestion(null);
            }
        }

        return $this;
    }

    public function getTitleType(): ?string
    {
        return $this->titleType;
    }

    public function setTitleType(string $titleType): self
    {
        $this->titleType = $titleType;

        return $this;
    }
}
