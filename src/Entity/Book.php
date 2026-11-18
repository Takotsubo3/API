<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['book:read']],
denormalizationContext: ['groups' => ['book:write']]
)]

class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['book:read'])]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:read', 'book:write'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $Title = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['book:read', 'book:write'])]
    #[Assert\Range(min:1400, max:2100)]
    private ?int $Publish_year = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['book:read', 'book:write'])]
    #[Assert\Positive]
    private ?int $nbPages = null;

    #[ORM\Column(length: 50, nullable: true, unique:true)]
    #[Groups(['book:read', 'book:write'])]
    private ?string $openLibraryId = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Groups(['book:read', 'book:write'])]
    private ?Author $author = null;

    /**
     * @var Collection<int, Genre>
     */
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'books')]
    #[Groups(['book:read', 'book:write'])]
    private Collection $genre;

    public function __construct()
    {
        $this->genre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getPublishYear(): ?int
    {
        return $this->Publish_year;
    }

    public function setPublishYear(?int $Publish_year): static
    {
        $this->Publish_year = $Publish_year;

        return $this;
    }

    public function getNbPages(): ?int
    {
        return $this->nbPages;
    }

    public function setNbPages(?int $nbPages): static
    {
        $this->nbPages = $nbPages;

        return $this;
    }

    public function getOpenLibraryId(): ?string
    {
        return $this->openLibraryId;
    }

    public function setOpenLibraryId(?string $openLibraryId): static
    {
        $this->openLibraryId = $openLibraryId;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genre->removeElement($genre);

        return $this;
    }
}
