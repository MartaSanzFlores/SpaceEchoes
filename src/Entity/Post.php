<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Author;
use App\Entity\Review;
use App\Entity\Picture;
use App\Entity\Category;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[UniqueEntity('title')]
#[ORM\HasLifecycleCallbacks]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['get_collection_post'])]
    private $id;

    #[ORM\Column(type: 'string', length: 400)]
    #[Assert\NotBlank]
    #[Groups(['get_collection_post'])]
    private $title;

    #[ORM\Column(type: 'string', length: 800)]
    #[Assert\NotBlank]
    #[Groups(['get_collection_post'])]
    private $excerpt;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    #[Groups(['get_collection_post'])]
    private $content;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    #[Groups(['get_collection_post'])]
    private $slug;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(['get_collection_post'])]
    private $publishedAt;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: 'posts')]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['get_collection_post'])]
    private $author;

    #[ORM\OneToOne(targetEntity: Picture::class, inversedBy: 'post', cascade: ['persist', 'remove'])]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['get_collection_post'])]
    private $picture;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $userPost;

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'post', orphanRemoval: true)]
    #[Groups(['get_collection_post'])]
    private $reviews;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'posts')]
    #[Groups(['get_collection_post'])]
    private $categories;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(?Picture $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
    
    public function getUserPost(): ?User
    {
        return $this->userPost;
    }
      
    public function setUserPost(?User $userPost): self
    {
        $this->userPost = $userPost;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setPost($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            if ($review->getPost() === $this) {
                $review->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
