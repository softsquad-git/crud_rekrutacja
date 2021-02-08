<?php

namespace App\Entity;

use App\Repository\BookRepository;
use App\Service\BookService;
use Doctrine\ORM\Mapping as ORM;
use \DateTimeInterface;
use \DateTime;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    public function __construct()
    {
        $this->created_at = new DateTime();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $publication_year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $isbn;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cover_src;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublicationYear(): ?string
    {
        return $this->publication_year;
    }

    public function setPublicationYear(string $publication_year): self
    {
        $this->publication_year = $publication_year;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getAuthorId(): ?Author
    {
        return $this->author_id;
    }

    public function setAuthorId(?Author $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }

    public function getCoverSrc(): ?string
    {
        return $this->cover_src;
    }

    public function setCoverSrc(string $cover_src): self
    {
        $this->cover_src = $cover_src;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImagePath(): ?string
    {
        if ($this->getCoverSrc()) {
            return BookService::IMAGE_PATH.$this->getCoverSrc();
        }

        return null;
    }
}
