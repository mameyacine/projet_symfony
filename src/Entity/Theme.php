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

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $imageUrl = null;

    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'theme')]
    private Collection $course;

    #[ORM\OneToMany(targetEntity: PostForum::class, mappedBy: 'themes')]
    private Collection $postForum;

    public function __construct()
    {
        $this->course = new ArrayCollection();
        $this->postForum = new ArrayCollection();
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

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }


    /**
     * @return Collection<int, Course>
     */
    public function getCourse(): Collection
    {
        return $this->course;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->course->contains($course)) {
            $this->course[] = $course;
            $course->setTheme($this);
        }
        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->course->removeElement($course)) {
            if ($course->getTheme() === $this) {
                $course->setTheme(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, PostForum>
     */
    public function getPostForum(): Collection
    {
        return $this->postForum;
    }

   

   
}
