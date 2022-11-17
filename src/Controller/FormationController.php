<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use App\Form\FormationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class FormationController extends AbstractController
{
    private EntityManagerInterface $em;
    private FormationRepository $rep;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->em = $entityManager;
        $this->rep = $entityManager->getRepository(Formation::class);
    }

    #[Route('/formation', name: 'app_formation')]
    public function index(): Response
    {
        $formations=$this->rep->findAll();
        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }
    
    #[Route('/formation/create', name: 'app_formation_create')]
    public function create( Request $request): Response
    {
        $formation=new Formation();

        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->rep->save($formation,true);
            
            return $this->redirectToRoute('app_formation');
        }
        return $this->renderForm('formation/create.html.twig', ['form'=>$form]);
    }
    #[Route('/formation/delete/{id}', name: 'app_formation_delete')]
    public function delete(FormationRepository $formationRepository, Request $request,$id): Response
    {
        $this->em->remove($formationRepository->find($id));
        $this->em->flush();
        return $this->redirectToRoute('app_formation');
    }
}
