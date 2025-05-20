<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Origin;
use App\Entity\Translation;
use App\Form\OriginType;
use App\Form\TranslationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OriginController extends AbstractController
{
    private const LANGUAGE_DEFAULT = 'DE';

    /*
     * Shows details of an origin text and the translation form
     */
    public function show(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $form = null;
        $origin = $entityManager->getRepository(Origin::class)->find($id);

        // create form for the translation
        if ($origin) {
            $translation = new Translation();
            $translation->setOrigin($origin);

            $form = $this->createForm(TranslationType::class, $translation);
            $form->get('origin_id')->setData($origin->getId());

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $translation = $form->getData();
                $translation->setTxt($form->get('translation')->getData());
                $translation->setCreated(new \DateTime());

                $entityManager->persist($translation);
                $entityManager->flush();

                return $this->redirectToRoute('list');
            }
        }

        return $this->render('origin.html.twig', [
            'origin' => $origin,
            'form' => $form
        ]);
    }

    /*
     * Creates a new origin text
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $origin = new Origin();

        $form = $this->createForm(OriginType::class, $origin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $language = $entityManager->getRepository(Language::class)->findOneBy([
                'iso_code' => self::LANGUAGE_DEFAULT
            ]);

            $origin = $form->getData();
            $origin->setLanguage($language);
            $origin->setCreated(new \DateTime());

            $entityManager->persist($origin);
            $entityManager->flush();

            return $this->redirectToRoute('list');
        }

        return $this->render('new.html.twig', [
            'form' => $form
        ]);
    }
}