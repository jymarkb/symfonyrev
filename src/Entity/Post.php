<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['post:read', 'category:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['post:read', 'category:read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['post:read', 'category:read'])]
    private ?string $imgSrc = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy:"post",  fetch: 'EAGER')]
    #[Groups(['post:read'])]
    private Category $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getImgSrc(): ?string
    {
        return $this->imgSrc;
    }

    public function setImgSrc(string $imgSrc): static
    {
        $this->imgSrc = $imgSrc;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
