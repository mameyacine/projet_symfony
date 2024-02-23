<?php
namespace App\Entity;

use App\Repository\NoteStudentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteStudentRepository::class)]
class NoteStudent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "float")]
    private ?float $score = null;

    #[ORM\ManyToOne(inversedBy: 'noteStudents')]
    private ?User $users = null;

    #[ORM\ManyToOne(inversedBy: 'noteStudents')]
    private ?QCM $QCMs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getQCMs(): ?QCM
    {
        return $this->QCMs;
    }

    public function setQCMs(?QCM $QCMs): self
    {
        $this->QCMs = $QCMs;

        return $this;
    }
}
