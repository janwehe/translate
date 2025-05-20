<?php

namespace App\Controller;

use App\Entity\Origin;
use App\Entity\Translation;
use App\Service\Translator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class TranslationController extends AbstractController
{
    /*
     * Loads a translation from the database
     */
    public function load(EntityManagerInterface $entityManager, int $origin_id, string $iso_code): JsonResponse
    {
        $transl = [
            'text' => ''
        ];

        $translation = $entityManager->getRepository(Translation::class)->findTranslationByIsoCode($origin_id, $iso_code);

        if ($translation) {
            $transl['text'] = $translation->getTxt();
        }

        return $this->json($transl);
    }

    /*
     * Uses the Translator Service to translate a text
     */
    public function translate(EntityManagerInterface $entityManager, Translator $translator, int $origin_id, string $iso_code): JsonResponse
    {
        $transl = [
            'text' => ''
        ];

        $origin = $entityManager->getRepository(Origin::class)->find($origin_id);

        if ($origin) {
            try {
                $transl['text'] = $translator->translate($origin, $iso_code);
            }
            catch (\Exception $e) {
                // in a real application the error would be saved in a logfile
                echo $e->getMessage();
            }
        }

        return $this->json($transl);
    }
}