<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(nullable: true, length: 180, unique: true)]
    private ?string $name = null;

    #[ORM\Column]
    private array $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(nullable: true)]
    private ?int $phoneNumber = null;


    #[ORM\OneToMany(targetEntity: Project::class, 
    mappedBy: 'owner')]
    private $projectsOwned;

    #[ORM\OneToMany(
        targetEntity: Post::class,
        mappedBy: 'author'
    )]
    private Collection $postsIncluded;

    public function __construct()
    {
        $this->projectsOwned = new ArrayCollection();
        $this->postsIncluded = new ArrayCollection();

    }

    public function getProjectsOwned()
    {
        return $this->projectsOwned;
    }

    public function addProject(Project $project): void
    {
        if (!$this->projectsOwned->contains($project)) 
        {
            $this->projectsOwned[] = $project;
            $project->setOwner($this);
        }
    }

    public function removeProject(Project $project)
    {
        if ($this->projectsOwned->removeElement($project))
        {
            if ($project->getOwner() === $this)
            {
                $project->setOwner(null);
            }
        }
        return $this;
    }

    // public function __construct()
    // {
    //     $this->date = new \DateTimeImmutable();
    // }

    // #[ORM\Column(type: "datetime_immutable")]
    // private \DateTimeImmutable $date = $this->date;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    // public function getDate(): ?\DateTimeImmutable
    // {
    //     return $this->date;
    // }

    // public function setDate(?\DateTimeImmutable $date): static
    // {
    //     $this->date = $date;

    //     return $this;
    // }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->postsIncluded;
    }
    public function addPost(Post $post): self
    {
        if (!$this->postsIncluded->contains($post))
        {
            $this->postsIncluded[] = $post;
            $post->setAuthor($this);
        }
        return $this;
    }
    public function removePost(Post $post): self
    {
        if ($this->postsIncluded->removeElement($post))
        {
            if ($post->getAuthor() === $this)
            {
                $post->setAuthor(null);
            }
        }
        return $this;
    }
}