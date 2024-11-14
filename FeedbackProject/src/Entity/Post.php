<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[Broadcast]
class Post
{
    // Define las opciones disponibles como constantes de la clase
    public const TYPE_BUG = "bug";
    public const TYPE_IDEA = "idea";
    public const TYPE_OTHER = "other";

    public const STATUS_NOT_REVIEWED = "not_reviewed";
    public const STATUS_IN_REVISION = "in_revision";
    public const STATUS_PROCESSED = "processed";
    public const STATUS_DESCARTED = "descarted";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length:20)]
    private ?string $type = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: Project::class, 
    inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    #[ORM\ManyToOne(
        targetEntity: User::class,
        inversedBy: 'postsIncluded'
    )]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    // Método que define las opciones disponibles para el formulario -> Que es la unica manera de definirlo
    // QUE NO SEA ACTIVANDO EL SETTER A MANIJA
    public static function getTypeChoices(): array
    {
        return [
            'Bug' => self::TYPE_BUG,
            'Idea' => self::TYPE_IDEA,
            'Other' => self::TYPE_OTHER,
        ];
    }
    public static function getStatusChoices(): array
    {
        return [
            'Not Reviewed' => self::STATUS_NOT_REVIEWED,
            'In revision' => self::STATUS_IN_REVISION,
            'Processed' => self::STATUS_PROCESSED,
            'Descarted' => self::STATUS_DESCARTED
        ];
    }

    // Metodo getter para retornar el valor actual de type
    public function getType(): string
    {
        return $this->type;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    // Metodo setter para definr un valor para type, acepta un string pero no chequea que sea igual a las opciones, eso lo hace el Form
    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this; // Permite encadenar metodos retornando la propia instancia
    }
    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;
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
    public function getProject(): ?Project
    {
        return $this->project;
    }
    public function setProject(?Project $project): self
    {
        $this->project = $project; 
        return $this;
    }
    public function getAuthor(): ?User
    {
        return $this->author;
    }
    public function setAuthor(?User $author): self
    {
        $this->author = $author;
        return $this;
    }
}
