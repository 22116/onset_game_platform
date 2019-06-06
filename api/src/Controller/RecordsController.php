<?php

namespace App\Controller;

use App\Entity\AudioManagerInterface;
use App\Entity\Record;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/** @Rest\Route("/api/records") */
class RecordsController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/{id}/{record}")
     */
    public function finish(string $id, string $record, AudioManagerInterface $audioManager, EntityManagerInterface $em): View
    {
        $score = intval(base64_decode($record)) + 999;
        $audio = $audioManager->find($id);

        if (!$audio) {
            throw new BadRequestHttpException();
        }

        $record = $audio->getRecord();

        if ($record && $record->getValue() < $score) {
            $record->setValue($score);
            $record->setProfile($this->getUser()->getProfile());

            $em->persist($record);
            $em->flush();

            return $this->view();
        }

        $record = new Record($audio, $this->getUser()->getProfile(), $score);

        $em->persist($record);
        $em->flush();

        return $this->view();
    }
}
