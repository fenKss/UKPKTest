<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace App\Entity;

use App\ENum\ETypedFieldType;
use App\Repository\TypedFieldRepository;
use Carbon\Exceptions\InvalidTypeException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypedFieldRepository::class)
 */
class TypedField
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;


    /**
     * @ORM\Column(type="smallint")
     */
    private ?int $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $text;

    /**
     * @ORM\ManyToOne(targetEntity=Image::class, cascade="remove")
     */
    private ?Image $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        ETypedFieldType::assertValidValue($type);
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
     * @return Image|string|null
     */
    public function getValue()
    {
        switch ($this->getType()) {
            case ETypedFieldType::TEXT_TYPE:
                return $this->getText();
            case ETypedFieldType::IMAGE_TYPE:
                return $this->getImage();
        }
        throw new InvalidTypeException("Invalid {$this->getType()}");
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }
}
