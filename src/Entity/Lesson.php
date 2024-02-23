<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $file = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $originalFileName = null;

   
    #[ORM\OneToMany(targetEntity: QCM::class, mappedBy: "lesson")]
    private $qcms;

    #[ORM\ManyToOne(targetEntity: Course::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    // ...

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }


    public function __construct()
    {
        $this->qcms = new ArrayCollection();
    }

    /**
     * @return Collection|QCM[]
     */
    public function getQcms(): Collection
    {
        return $this->qcms;
    }

  


    public function getOriginalFileName(): ?string
    {
        return $this->originalFileName;
    }

    public function setOriginalFileName(?string $originalFileName): self
    {
        $this->originalFileName = $originalFileName;

        return $this;
    }

    private ?UploadedFile $fileObject = null;
    private ?string $fileName = null;

    // Ajoutez ces méthodes pour gérer le nom du fichier
    public function getFileName(): ?string
    {
        return $this->fileName;
    }
    
    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;
    
        return $this;
    }
    
    public function getFileObject(): ?UploadedFile
    {
        return $this->fileObject;
    }

    public function setFileObject(?UploadedFile $fileObject): self
    {
        $this->fileObject = $fileObject;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;
        return $this;
    }


    public function getOriginalName(): ?string
    {
        $fileName = $this->getFileObject();
        if ($fileName instanceof UploadedFile) {
            return $fileName->getClientOriginalName();
        }

        return null;
    }
}



