<?php

namespace App\Entity;

use App\Repository\PostForumRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostForumRepository::class)]
class PostForum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'postForums')]
    private ?User $students = null;

    #[ORM\ManyToOne(inversedBy: 'postForums')]
    private ?Theme $themes = null;

    #[ORM\ManyToOne(inversedBy: 'postForums')]
    private ?Course $courses = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStudents(): ?User
    {
        return $this->students;
    }

    public function setStudents(?User $students): static
    {
        $this->students = $students;

        return $this;
    }

    public function getThemes(): ?Theme
    {
        return $this->themes;
    }

    public function setThemes(?Theme $themes): static
    {
        $this->themes = $themes;

        return $this;
    }

    public function getCourses(): ?Course
    {
        return $this->courses;
    }

    public function setCourses(?Course $courses): static
    {
        $this->courses = $courses;

        return $this;
    }
}
