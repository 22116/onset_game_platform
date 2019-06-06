<?php

namespace App\Controller;

use App\Communications\Api\OnsetDetectorInterface;
use App\Entity\Audio;
use App\Entity\AudioManagerInterface;
use App\Form\AudioType;
use App\Utils\TagReaderInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

/** @Rest\Route("/api/audio") */
class AudioController extends AbstractFOSRestController
{
    /**
     * @Rest\View()
     * @Rest\Post()
     */
    public function upload(
        Request $request,
        OnsetDetectorInterface $onsetDetector,
        TagReaderInterface $tagReader,
        AudioManagerInterface $audioManager
    ): View {
        $audio = new Audio();
        $form = $this->createForm(AudioType::class, $audio);
        $form->submit($request->files->getIterator()->getArrayCopy());

        if (!$form->isValid()) {
            return $this->view($form);
        }

        $file = $audio->getFile();
        $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

        try {
            $file->move(
                $this->getParameter('audio_directory'),
                $fileName
            );
        } catch (FileException $e) {
            $this->view(['Can not save a file'], 500);
        }

        $audio->setFile($fileName);

        $onset = $onsetDetector->getData($fileName);
        $tmpAudio = $audioManager->findByFft($onset->getFft());
        $fullpath = $this->getParameter('audio_directory').DIRECTORY_SEPARATOR.$fileName;

        if ($tmpAudio) {
            $filesystem = new Filesystem();
            $filesystem->remove($fullpath);

            return $this->view($tmpAudio);
        }

        $tags = $tagReader->read($fullpath);

        $title = (isset($tags['Title']) ? $tags['Title'].' ' : '') .
            (isset($tags['Author']) ? $tags['Author'].' ' : '') .
            (isset($tags['Album']) ? $tags['Album'].' ' : '');

        $audio->setBeats($onset->getBeats());
        $audio->setFft($onset->getFft());
        $audio->setDuration($onset->getDuration());

        $title = trim($title ?? '') ?: 'Unknown('.$this->generateUniqueFileName().')';

        $audio->setTitle($title);
        $audioManager->save($audio);

        return $this->view($audio);
    }

    /**
     * @Rest\Get()
     */
    public function records(AudioManagerInterface $audioManager): View
    {
        return $this->view($audioManager->findAll());
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function audio(int $id, AudioManagerInterface $audioManager): View
    {
        return $this->view($audioManager->find($id));
    }


    private function generateUniqueFileName(): string
    {
        return md5(uniqid());
    }
}
