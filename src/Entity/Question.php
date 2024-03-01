<?php
namespace App\Entity;

use App\Entity\Lesson;
use App\Entity\QCM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

#[ORM\Entity]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "text")]
    private $content;

    #[ORM\ManyToOne(targetEntity: Lesson::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $lesson;

    #[ORM\Column(type: "json")]
    private $answers;

    #[ORM\Column(type: "integer")]
    private $correctAnswerIndex;

    #[ORM\ManyToOne(targetEntity: QCM::class, inversedBy: "questions")]
    #[ORM\JoinColumn(nullable: false)]
    private $qcm;

    public function __construct()
    {
        // Initialize the answers property as an empty array
        $this->answers = ['', '', '', ''];
        
    }

    public function getQcm(): ?QCM
    {
        return $this->qcm;
    }

    public function setQcm(?QCM $qcm): self
    {
        $this->qcm = $qcm;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getContent(): ?string
    {
        return $this->content;
    }
    
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }
    
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }
    
    public function setLesson(?Lesson $lesson): self
    {
        $this->lesson = $lesson;
        return $this;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function setAnswers(array $answers): self
    {
        $this->answers = $answers;
        return $this;
    }

    public function addAnswer(string $answer): self
    {
        $this->answers[] = $answer;
        return $this;
    }

    public function getCorrectAnswerIndex(): ?int
    {
        return $this->correctAnswerIndex;
    }
    
    public function setCorrectAnswerIndex(int $correctAnswerIndex): self
    {
        $this->correctAnswerIndex = $correctAnswerIndex;
        return $this;
    }
}
