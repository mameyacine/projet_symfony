<?php

namespace App\Command;

use App\Entity\QCM;
use App\Repository\QCMRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Filesystem\Filesystem;

class GenerateXMLCommand extends Command
{
    private $qcmRepository;
    private $xmlEncoder;
    private $filesystem;

    public function __construct(QCMRepository $qcmRepository, XmlEncoder $xmlEncoder, Filesystem $filesystem)
    {
        $this->qcmRepository = $qcmRepository;
        $this->xmlEncoder = $xmlEncoder;
        $this->filesystem = $filesystem;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:generate-xml')
            ->setDescription('Generate XML files for QCM entities from the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $qcms = $this->qcmRepository->findAll();
    
        foreach ($qcms as $qcm) {
            // Récupérer les données du QCM et les formater
            $qcmData = $this->prepareQcmData($qcm);
    
            // Convertir les données en format XML
            $xmlContent = $this->xmlEncoder->encode($qcmData, 'xml');
    
            // Sauvegarder le contenu XML dans un fichier
            $this->saveQCMXmlToFile($qcm, $xmlContent);
            $output->writeln(sprintf('XML file generated for QCM with ID %d', $qcm->getId()));
        }
    
        $output->writeln('XML files generation completed.');
    
        return Command::SUCCESS;
    }
    
    
    

    private function prepareQcmData(QCM $qcm): array
    {
        // Récupérer les données du QCM
        $qcmData = [
            'title' => $qcm->getTitle(), // Titre du QCM
            'course' => $qcm->getCourse()->getName(), // Nom du cours associé au QCM
            'questions' => [],
        ];

        // Récupérer les questions du QCM
        $questions = $qcm->getQuestions();

        // Boucle sur chaque question pour récupérer ses données
        foreach ($questions as $question) {
            $questionData = [
                'lesson' => $question->getLesson()->getName(), // Nom de la leçon associée à la question
                'content' => $question->getContent(),
                'answers' => $question->getAnswers(),
                'correctAnswerIndex' => $question->getCorrectAnswerIndex(),
                // Ajoutez d'autres données de question si nécessaire
            ];
            $qcmData['questions'][] = $questionData;
        }

        return $qcmData;
    }

    private function saveQCMXmlToFile(QCM $qcm, string $xmlContent): void
    {
         // Spécifier le chemin complet où vous souhaitez enregistrer le fichier XML
         $filePath = __DIR__ . '/../../src/Command/qcms/qcm_' . $qcm->getId() . '.xml';

         // Vérifier si le dossier qcms existe, sinon le créer de manière récursive
         $directoryPath = dirname($filePath);
         if (!is_dir($directoryPath)) {
             mkdir($directoryPath, 0777, true);
         }

        // Enregistrer le contenu XML dans le fichier
        file_put_contents($filePath, $xmlContent);
    }
}
