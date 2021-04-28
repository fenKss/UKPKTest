<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace App\Entity;

use App\ENum\EQuestionTextType;
use App\ENum\EQuestionType;
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
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Variant::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Variant $variant;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private ?string $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $title;

    /**
     * @ORM\OneToMany(targetEntity=QuestionOption::class, mappedBy="question")
     */
    private Collection $options;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $titleType;

    public function __construct()
    {
        $this->options = new ArrayCollection();
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType($type): self
    {
        EQuestionType::assertValidValue($type);
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
     * @return Collection|QuestionOption[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(QuestionOption $questionOption): self
    {
        if (!$this->options->contains($questionOption)) {
            $this->options[] = $questionOption;
            $questionOption->setQuestion($this);
        }

        return $this;
    }

    public function removeOption(QuestionOption $questionOption): self
    {
        if ($this->options->removeElement($questionOption)) {
            // set the owning side to null (unless already changed)
            if ($questionOption->getQuestion() === $this) {
                $questionOption->setQuestion(null);
            }
        }

        return $this;
    }

    public function getTitleType(): ?int
    {
        return $this->titleType;
    }

    public function setTitleType($titleType): self
    {
        EQuestionTextType::assertValidValue($titleType);
        $this->titleType = $titleType;

        return $this;
    }
}
