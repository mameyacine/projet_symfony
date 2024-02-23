<?php
namespace App\Entity;

use App\Repository\QCMRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Question;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: QCMRepository::class)]
class QCM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $title;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'qcms', cascade: ["persist"])]
    private ?Course $course;



    #[ORM\OneToMany(targetEntity: Question::class, mappedBy: "qcm")]
    private $questions;

    #[ORM\OneToMany(targetEntity: NoteStudent::class, mappedBy: 'QCMs')]
    private Collection $noteStudents;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->course = null; //
        $this->noteStudents = new ArrayCollection();
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setQcm($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQcm() === $this) {
                $question->setQcm(null);
            }
        }

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
    
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
    
    public function getCourse(): ?Course
    {
        return $this->course;
    }
    
    public function setCourse(?Course $course): self
    {
        $this->course = $course;
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
            $noteStudent->setQCMs($this);
        }

        return $this;
    }

    public function removeNoteStudent(NoteStudent $noteStudent): static
    {
        if ($this->noteStudents->removeElement($noteStudent)) {
            // set the owning side to null (unless already changed)
            if ($noteStudent->getQCMs() === $this) {
                $noteStudent->setQCMs(null);
            }
        }

        return $this;
    }
    

    
}


