<?php

namespace App\Controller;

use App\Entity\Edition;
use App\Form\EditionType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditionController extends AbstractController
{
    #[Route('/edition', name: 'editions_show')]
    public function showAll(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $editions = $entityManager->getRepository(Edition::class)->findAll();

        // Paginer les données
        $pagination = $paginator->paginate(
            $editions, // Les données à paginer
            $request->query->getInt('page', 1), // Numéro de page à afficher, 1 par défaut
            12 // Nombre d'éléments par page
        );

        // Passer les données paginées au template Twig
        return $this->render('edition/editions.html.twig', [
            'pagination' => $pagination,
        ]);
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
            return $this->redirectToRoute('show_editon', ['id' => $edition->getId()]);
        }

        return $this->render('edition/formEdition.html.twig', array(
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

        return $this->render('edition/edition.html.twig', [
            'edition' => $edition,
        ]);
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

    #[Route('/edition/{id}/delete', name: 'delete_edition')]
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

        return $this->redirectToRoute('editions_show') ;
    }

    #[Route("/edition/{id}/update", name: "edition_update")]
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
            return $this->redirectToRoute('show_editon', ['id' => $edition->getId()]);
        }

        return $this->render('edition/formEdition.html.twig', array(
            'form' => $form,
        ));
    }
}
