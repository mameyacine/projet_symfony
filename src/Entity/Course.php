<?php

namespace App\Entity;
use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'courses')]
    private Collection $users;

    #[ORM\OneToMany(targetEntity: Lesson::class, mappedBy: 'course')]
    private Collection $lessons;

    #[ORM\ManyToOne(targetEntity: Theme::class, inversedBy: 'courses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Theme $theme = null;

    #[ORM\OneToMany(targetEntity: PostForum::class, mappedBy: 'courses')]
    private Collection $postForums;


    #[ORM\OneToMany(targetEntity: QCM::class, mappedBy: 'course')]
    private Collection $qcms;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addCourse($this); // Ajouter le cours à l'utilisateur
        }
        return $this;
    }
    
    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCourse($this); // Retirer le cours de l'utilisateur
        }
        return $this;
    }
    
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setCourse($this);
        }
        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            if ($lesson->getCourse() === $this) {
                $lesson->setCourse(null);
            }
        }
        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;
        return $this;
    }

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->lessons = new ArrayCollection();
        $this->postForums = new ArrayCollection();
        $this->qcms = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name ?? '';
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
            $postForum->setCourse($this);
        }

        return $this;
    }

    public function removePostForum(PostForum $postForum): static
    {
        if ($this->postForums->removeElement($postForum)) {
            // set the owning side to null (unless already changed)
            if ($postForum->getCourse() === $this) {
                $postForum->setCourse(null);
            }
        }

        return $this;
    }

    public function getQcms(): Collection
    {
        return $this->qcms;
    }

    public function addQcm(QCM $qcm): self
    {
        if (!$this->qcms->contains($qcm)) {
            $this->qcms[] = $qcm;
            $qcm->setCourse($this);
        }

        return $this;
    }

    public function removeQcm(QCM $qcm): self
    {
        if ($this->qcms->removeElement($qcm)) {
            // set the owning side to null (unless already changed)
            if ($qcm->getCourse() === $this) {
                $qcm->setCourse(null);
            }
        }

        return $this;
    }


}
