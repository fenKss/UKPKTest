<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace App\Entity;

use App\Repository\TourRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TourRepository::class)
 */
class Tour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Olympic::class, inversedBy="tours")
     */
    private ?Olympic $olympic;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $price;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $startedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $expiredAt;

    /**
     * @ORM\OneToMany(targetEntity=Test::class, mappedBy="tour")
     */
    private Collection $tests;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $publishedAt;

    /**
     * @ORM\Column(type="smallint")
     */
    private ?int $tourIndex;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOlympic(): ?Olympic
    {
        return $this->olympic;
    }

    public function setOlympic(?Olympic $olympic): self
    {
        $this->olympic = $olympic;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }


    public function getStartedAt(): ?DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getExpiredAt(): ?DateTimeInterface
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(?DateTimeInterface $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

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
            $test->setTour($this);
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        if ($this->tests->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getTour() === $this) {
                $test->setTour(null);
            }
        }

        return $this;
    }

    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getTourIndex(): ?int
    {
        return $this->tourIndex;
    }

    public function setTourIndex(int $tourIndex): self
    {
        $this->tourIndex = $tourIndex;

        return $this;
    }

    public function canUserSignUp(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        $tourIndex = $this->getTourIndex();
        $olympic   = $this->getOlympic();
        $canSignUp = true;
        foreach ($user->getUserTests() as $userTest) {
            $tour        = $userTest->getVariant()->getTest()->getTour();
            $testOlympic = $tour->getOlympic();
            if ($olympic->getId() != $testOlympic->getId()) {
                continue;
            }
            if ($tour->getTourIndex() >= $tourIndex) {
                $canSignUp = false;
                break;
            }
        }
        return $canSignUp;
    }
}
