<?php

namespace App\Entity;

use App\Repository\VariantQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VariantQuestionRepository::class)
 */
class VariantQuestion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Variant::class, inversedBy="variantQuestions")
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
    private $text;

    /**
     * @ORM\OneToMany(targetEntity=QuestionOption::class, mappedBy="question")
     */
    private $questionOptions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $textType;

    public function __construct()
    {
        $this->questionOptions = new ArrayCollection();
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection|QuestionOption[]
     */
    public function getQuestionOptions(): Collection
    {
        return $this->questionOptions;
    }

    public function addQuestionOption(QuestionOption $questionOption): self
    {
        if (!$this->questionOptions->contains($questionOption)) {
            $this->questionOptions[] = $questionOption;
            $questionOption->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionOption(QuestionOption $questionOption): self
    {
        if ($this->questionOptions->removeElement($questionOption)) {
            // set the owning side to null (unless already changed)
            if ($questionOption->getQuestion() === $this) {
                $questionOption->setQuestion(null);
            }
        }

        return $this;
    }

    public function getTextType(): ?string
    {
        return $this->textType;
    }

    public function setTextType(string $textType): self
    {
        $this->textType = $textType;

        return $this;
    }
}
