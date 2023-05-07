<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\StatusType;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: false)]
    private ?string $title = null;

    #[ORM\Column(nullable: false)]
    private ?string $image = null;

    #[ORM\Column(nullable: false)]
    private ?string $filname = null;

    #[ORM\Column(nullable: false)]
    private ?string $url = null;

    #[ORM\Column(nullable: false)]
    private ?string $description = null;

    #[ORM\Column(nullable: false)]
    private ?int $numberTasks = null;

    #[ORM\Column(name: 'status', type: 'string', nullable: false, enumType: StatusType::class)]
    #[Groups(groups: [Status::GROUP_DEFAULT])]
    private StatusType $status = StatusType::in_progress;


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getFilname(): ?string
    {
        return $this->filname;
    }

    public function setFilname(string $filname): self
    {
        $this->filname = $filname;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberTasks(): ?int
    {
        return $this->numberTasks;
    }

    public function setNumberTasks(int $numberTasks): self
    {
        $this->numberTasks = $numberTasks;

        return $this;
    }

    public function getStatus(): StatusType
    {
        return $this->status;
    }

    public function setStatus(StatusType $status): self
    {
        $this->status = $status;

        return $this;
    }

   }
