<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace App\Entity;

use App\ENum\EOptionType;
use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 */
class QuestionOption
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="options")
     */
    private ?Question $question;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isCorrect;

    /**
     * @ORM\ManyToOne(targetEntity=TypedField::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?TypedField $body;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getIsCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): self
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    public function getBody(): ?TypedField
    {
        return $this->body;
    }

    public function setBody(?TypedField $body): self
    {
        $this->body = $body;

        return $this;
    }

}
