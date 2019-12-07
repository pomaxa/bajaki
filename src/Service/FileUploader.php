<?php


namespace App\Service;

use League\Flysystem\FilesystemInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;
    /**
     * @var FilesystemInterface
     */
    private $usersStorage;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(string $targetDirectory, FilesystemInterface $usersStorage, LoggerInterface $logger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->usersStorage = $usersStorage;
        $this->logger = $logger;
    }

    public function getFilesystem()
    {
        return $this->usersStorage;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $fileName = 'avatars/'.$safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $stream = fopen($file->getRealPath(), 'r+');
            $this->usersStorage->writeStream(
                $fileName,
                $stream
            );
            fclose($stream);
        } catch (FileException $e) {
            $this->logger->critical($e->getMessage());
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
