<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Form\CarteType;
use App\Form\SearchFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

class CarteController extends AbstractController
{
    #[Route('/carte/insert', name: 'insert_carte')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $carte = new Carte();
        $form = $this->createForm(CarteType::class, $carte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carte= $form->getData();
            $entityManager->persist($carte);
            $entityManager->flush();
            return $this->redirectToRoute('carte_show', ['id' => $carte->getId()]);
        }

        return $this->render('carte/formCarte.html.twig',array(
            'form' => $form,
        ));
    }


    public function createCarte(EntityManagerInterface $entityManager):Response{
        $carte = new Carte();
        $carte->setCarteNom("Les alliés de Ron");
        $carte->setCarteCategorie("Magie");
        $carte->setCarteImage("Indisponible");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($carte);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response("La carte ".$carte->getCarteNom()." a été ajoutée à la base de données avec succès !");
    }

    #[Route('/carte', name: 'cartes_show')]
    public function showAll(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $searchTerm = $request->query->get('searchTerm');
        // Récupérer les données à paginer depuis la base de données
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        // Si le formulaire de recherche est soumis et valide, rediriger vers la route resultat_recherche
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $searchTerm = $data['search'];
            return $this->redirectToRoute('cartes_show', ['searchTerm' => $searchTerm]);
        }

        // Récupérer le numéro de la page demandée
        $page = $request->query->getInt('page', 1);

        // Calculer l'offset en fonction du numéro de page
        $offset = ($page - 1) * 10;


        // Récupérer le nombre total de cartes
        $totalCartes = $entityManager->getRepository(Carte::class)->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // Calculer le nombre total de pages
        $totalPages = ceil($totalCartes / 10);

        if ($searchTerm !== null) {
            $cartesQuery = $entityManager->getRepository(Carte::class)->createQueryBuilder('c');
            $cartesQuery->andWhere('c.carte_nom LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$searchTerm.'%');
            $cartes = $cartesQuery->getQuery()->getResult();
        } else {
            $cartesQuery = $entityManager->getRepository(Carte::class)->createQueryBuilder('c')->setFirstResult($offset);
            $cartes = $cartesQuery

                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        }

        // Passer les données paginées au template Twig
        return $this->render('carte/cartes.html.twig', [
            'form' => $form->createView(),
            'cartes' => $cartes,
            'page' => $page,
            'totalPages' => $totalPages,
            'searchTerm' => $searchTerm, // Passer le terme de recherche à la vue
        ]);
    }


    #[Route('/carte/{id}', name: 'carte_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $carte = $entityManager->getRepository(Carte::class)->find($id);

        if (!$carte) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('carte/carte.html.twig', [
            'carte' => $carte,
        ]);
    }

    #[Route('/carte/{id}/update', name: 'update_carte')]
    public function actionUpdate(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $carte = $entityManager->getRepository(Carte::class)->find($id);
        $form = $this->createForm(CarteType::class, $carte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carte = $form->getData();
            $entityManager->persist($carte);
            $entityManager->flush();
            return $this->redirectToRoute('carte_show', ['id' => $carte->getId()]);
        }

        return $this->render('carte/formCarte.html.twig', array(
            'form' => $form,
        ));
    }

    public function update(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Carte::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setCarteNom($product->getCarteNom()." modifié");
        $entityManager->flush();

        return new Response('Ce qui a été mise à jour : '.$product->getCarteNom());
    }

    #[Route('/carte/{id}/delete', name: 'delete_carte')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Carte::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('cartes_show') ;

    }

}
