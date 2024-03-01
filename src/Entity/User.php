<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private ?string $email= null;

    #[ORM\Column]

    private ?string $firstname = null;

    #[ORM\Column]

    private ?string $lastname = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Course::class, mappedBy: 'users')]
    private Collection $courses;

    #[ORM\OneToMany(targetEntity: NoteStudent::class, mappedBy: 'users')]
    private Collection $noteStudents;

    #[ORM\OneToMany(targetEntity: PostForum::class, mappedBy: 'students')]
    private Collection $postForums;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->noteStudents = new ArrayCollection();
        $this->postForums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
       

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

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }
    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->addUser($this); // Ajouter l'utilisateur au cours, pas l'inverse
        }
        return $this;
    }
    
    

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            $course->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, NoteStudent>
     */
    public function getNoteStudents(): Collection
    {
        return $this->noteStudents;
    }

    public function addNoteStudent(NoteStudent $noteStudent): static
    {
        if (!$this->noteStudents->contains($noteStudent)) {
            $this->noteStudents->add($noteStudent);
            $noteStudent->setUsers($this);
        }

        return $this;
    }

    public function removeNoteStudent(NoteStudent $noteStudent): static
    {
        if ($this->noteStudents->removeElement($noteStudent)) {
            // set the owning side to null (unless already changed)
            if ($noteStudent->getUsers() === $this) {
                $noteStudent->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostForum>
     */
    public function getPostForums(): Collection
    {
        return $this->postForums;
    }

    public function addPostForum(PostForum $postForum): static
    {
        if (!$this->postForums->contains($postForum)) {
            $this->postForums->add($postForum);
            $postForum->setStudent($this);
        }

        return $this;
    }

    public function removePostForum(PostForum $postForum): static
    {
        if ($this->postForums->removeElement($postForum)) {
            // set the owning side to null (unless already changed)
            if ($postForum->getStudent() === $this) {
                $postForum->setStudent(null);
            }
        }

        return $this;
    }
}
