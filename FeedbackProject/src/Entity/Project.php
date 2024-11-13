<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\Turbo\Attribute\Broadcast;
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[Broadcast]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_active = true;
    #
    #[ORM\ManyToOne(targetEntity: User::class,
     inversedBy: 'projectsOwned')]
    #[ORM\JoinColumn(name: 'project_owner_id', 
    referencedColumnName: 'id',
    nullable: false)]
    private $owner;

    #[ORM\OneToMany(targetEntity: Post::class,
    mappedBy: 'project')]

    private Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(?bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts():Collection
    {
        return $this->posts;
    }
    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($this)) 
        {
            $this->posts[] = $this;
            $post->setProject($this);
        }
        return  $this;
    }
    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post))
        {
            if ($post->getProject() === $this)
            {
                $post->setProject(null);
            }
        }
        return $this;
    }
}
