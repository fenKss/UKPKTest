<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace App\Entity;

use App\Repository\OlympicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OlympicRepository::class)
 */
class Olympic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="smallint")
     */
    private ?int $type;

    /**
     * @ORM\OneToMany(targetEntity=Tour::class, mappedBy="olympic")
     */
    private Collection $tours;

    /**
     * @ORM\ManyToMany(targetEntity=Language::class, inversedBy="olympics")
     */
    private Collection $languages;


    public function __construct()
    {
        $this->tours = new ArrayCollection();
        $this->languages = new ArrayCollection();
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Tour[]
     */
    public function getTours(): Collection
    {
        return $this->tours;
    }

    public function addTour(Tour $tour): self
    {
        if (!$this->tours->contains($tour)) {
            $this->tours[] = $tour;
            $tour->setOlympic($this);
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        if ($this->tours->removeElement($tour)) {
            // set the owning side to null (unless already changed)
            if ($tour->getOlympic() === $this) {
                $tour->setOlympic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        $this->languages->removeElement($language);

        return $this;
    }
}
