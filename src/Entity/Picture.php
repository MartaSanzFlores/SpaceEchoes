<?php

namespace App\Entity;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PictureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Picture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_collection_picture"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2083)
     * @Groups({"get_collection_post", "get_collection_picture"})
     * @Assert\NotBlank
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Groups({"get_collection_picture"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=500)
     * @Groups({"get_collection_post", "get_collection_picture"})
     * @Assert\NotBlank
     */
    private $credit;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"get_collection_post", "get_collection_picture"})
     * @Assert\NotBlank
     */
    private $altText;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     */
    private $galery;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"get_collection_picture"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"get_collection_picture"})
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=Post::class, mappedBy="picture", cascade={"persist", "remove"})
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $UserPicture;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="pictures")
     */
    private $usersLikes;

    
    public function __construct()
    {
        $this->usersLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCredit(): ?string
    {
        return $this->credit;
    }

    public function setCredit(?string $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getAltText(): ?string
    {
        return $this->altText;
    }

    public function setAltText(?string $altText): self
    {
        $this->altText = $altText;

        return $this;
    }

    public function isGalery(): ?bool
    {
        return $this->galery;
    }

    public function setGalery(bool $galery): self
    {
        $this->galery = $galery;

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

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(Post $post): self
    {
        // set the owning side of the relation if necessary
        if ($post->getPicture() !== $this) {
            $post->setPicture($this);
        }

        $this->post = $post;

        return $this;
    }

    public function getUserPicture(): ?User
    {
        return $this->UserPicture;
    }

    public function setUserPicture(?User $UserPicture): self
    {
        $this->UserPicture = $UserPicture;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersLikes(): Collection
    {
        return $this->usersLikes;
    }
         
    public function addUsersLike(User $usersLike): self
    {
        if (!$this->usersLikes->contains($usersLike)) {
            $this->usersLikes[] = $usersLike;
        }

        return $this;
    }

    public function removeUsersLike(User $usersLike): self
    {
        $this->usersLikes->removeElement($usersLike);

        return $this;
    }
}
