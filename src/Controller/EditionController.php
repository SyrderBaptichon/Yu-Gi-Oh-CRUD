<?php

namespace App\Controller;

use App\Entity\Edition;
use App\Form\EditionType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditionController extends AbstractController
{
    #[Route('/editions', name: 'app_edition')]
    public function showAll(EntityManagerInterface $entityManager): Response
    {
        $editions = $entityManager->getRepository(Edition::class)->findAll();

        if (!$editions) {
            throw $this->createNotFoundException('Aucune édition trouvée !');
        }

        $tableRows = '';
        foreach ($editions as $edition) {
            $tableRows .= '
            <tr>
                <td>' . $edition->getNomEdition() . '</td>
                <td>' . $edition->getId() . '</td>
                <td>' . $edition->getDateEdition()->format('Y-m-d') . '</td>
            </tr>
        ';
        }

        $html = '
        <h1>Voici les éditions :</h1>
        <table class="table is-bordered is-striped is-hoverable is-narrow is-fullwidth" border="1">
            <thead>
                <tr>
                    <th>Nom de l\'édition</th>
                    <th>Numéro de l\'édition</th>
                    <th>Date de l\'édition</th>
                </tr>
            </thead>
            <tbody>
                ' . $tableRows . '
            </tbody>
        </table>
    ';
        return new Response($html);
    }


    public function createEdition(EntityManagerInterface $entityManager): Response
    {
        $edition = new Edition();
        $edition->setNomEdition('aaa');
        $date = new DateTime();
        $edition->setDateEdition($date);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($edition);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response("L'édition ".$edition->getNomEdition()." à été ajouter à la base de donnée avec succès !");
    }

    #[Route("/edition/insert/", name: "edition_insert")]
    public function actionInsert(EntityManagerInterface $entityManager, Request $request): Response
    {
        $edition = new Edition();
        $form = $this->createForm(EditionType::class, $edition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $edition = $form->getData();
            $entityManager->persist($edition);
            // but, the original `$task` variable has also been updated
            $entityManager->flush();
            return $this->redirectToRoute('app_edition');
        }

        return $this->render('edition/edition.html.twig', array(
            'form' => $form,
        ));
    }

    #[Route('/edition/{id}', name: 'show_editon')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $edition = $entityManager->getRepository(Edition::class)->find($id);

        if (!$edition) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Voici l\'édition: '.$edition->getNomEdition());
    }

    public function update(EntityManagerInterface $entityManager, int $id): Response
    {
        $edition = $entityManager->getRepository(Edition::class)->find($id);

        if (!$edition) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $edition->setNomEdition('aaa');
        $entityManager->flush();

        return new Response('Ce qui a été mise à jour : '.$edition->getNomEdition());
    }

    #[Route('/edition/delete/{id}', name: 'delete_edition')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $edition = $entityManager->getRepository(Edition::class)->find($id);

        if (!$edition) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($edition);
        $entityManager->flush();

        return new Response('Ce qui a été supprimer : '.$edition->getNomEdition());
    }

    #[Route("/edition/update/{id}", name: "edition_update")]
    public function actionUpdate(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $edition = $entityManager->getRepository(Edition::class)->find($id);
        $form = $this->createForm(EditionType::class, $edition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $edition = $form->getData();
            $entityManager->persist($edition);
            // but, the original `$task` variable has also been updated
            $entityManager->flush();
            return $this->redirectToRoute('app_edition');
        }

        return $this->render('edition/edition.html.twig', array(
            'form' => $form,
        ));
    }
}
