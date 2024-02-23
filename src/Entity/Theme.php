<?php
namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'theme')]
    private Collection $courses;

    #[ORM\OneToMany(targetEntity: PostForum::class, mappedBy: 'themes')]
    private Collection $postForums;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->postForums = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setTheme($this);
        }
        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            if ($course->getTheme() === $this) {
                $course->setTheme(null);
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
            $postForum->setThemes($this);
        }

        return $this;
    }

    public function removePostForum(PostForum $postForum): static
    {
        if ($this->postForums->removeElement($postForum)) {
            // set the owning side to null (unless already changed)
            if ($postForum->getThemes() === $this) {
                $postForum->setThemes(null);
            }
        }

        return $this;
    }
}
