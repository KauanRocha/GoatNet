<?php

namespace App\Controller;

use App\Entity\Goat;
use App\Form\GoatType;
use App\Repository\GoatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/goat')]
class GoatController extends AbstractController
{
    #[Route('/', name: 'app_goat_index', methods: ['GET'])]
    public function index(GoatRepository $goatRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
        $goatRepository->findByGoatLive(),
        $request->query->get('page', 1),
        5
    );
        
        return $this->render('goat/index.html.twig', [
            'goats' =>$pagination,
            'title' => 'Meus animais',
        ]);
    }

    #[Route('/new', name: 'app_goat_new', methods: ['GET', 'POST'])]
    public function new(GoatRepository $goatRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $goat = new Goat();
        $form = $this->createForm(GoatType::class, $goat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $goatRepository->save($goat, true);

            $this->addFlash(
                'message',
                'Cabra cadastrada com sucesso!'
            );

            $label = 'success';

            $pagination = $paginator->paginate(
                $goatRepository->findByGoatLive(),
                $request->query->get('page', 1),
                5
            );

            return $this->render('goat/index.html.twig', [
                'label' =>$label,
                'goats' => $pagination,
                'title' => 'Meus animais',
            ]);
        }

        

        return $this->render('goat/new.html.twig', [
            'goat' => $goat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_goat_edit', methods: ['GET', 'POST'])]
    public function edit(GoatRepository $goatRepository, Request $request, Goat $goat, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(GoatType::class, $goat);
        $form->handleRequest($request);
        $label = 'success';

        if ($form->isSubmitted() && $form->isValid()) {
            $goatRepository->save($goat, true);

            $this->addFlash(
                'message',
                'Informações editadas com sucesso!'
            );

            $pagination = $paginator->paginate(
                $goatRepository->findByGoatLive(),
                $request->query->get('page', 1),
                5
            );
            
            return $this->render('goat/index.html.twig', [
                'label' =>$label,
                'goats' => $pagination,
                'title' => 'Meus animais',
            ]);
        }

        return $this->render('goat/edit.html.twig', [
            'label' => $label,
            'goat' => $goat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/excluir', name: 'goatDelete', methods: ['GET'])]
    public function delete(Request $request, Goat $goat, GoatRepository $goatRepository, PaginatorInterface $paginator): Response
    {
        $deletedAt = new \DateTimeImmutable ;
        $goat->setDeletedAt($deletedAt);
        $goatRepository->save($goat, true);



        return $this->redirectToRoute('app_goat_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/abater', name: 'goatAbater', methods: ['GET', 'POST'])]
    public function abater(Request $request, Goat $goat, GoatRepository $goatRepository, PaginatorInterface $paginator): Response
    {

        

        $podeAbater = 0;

            $dataNasc = $goat->getDataNasc();
            $dataAtual = new \DateTime();

            $diferenca = $dataNasc->diff($dataAtual);
            $idade = $diferenca->y;

            if($goat->getLeiteProd() < 40){
                $podeAbater = true;
            }elseif($goat->getLeiteProd() < 70 and $goat->getRacaoCons() > 350){
                $podeAbater = true;
            }elseif($idade >= 5){
                $podeAbater = true;
            }elseif($goat->getPeso() > 270){
                $podeAbater = true;
            }
        
        if($podeAbater) {  
            
            $pagination = $paginator->paginate(
                $goatRepository->findByGoatLive(),
                $request->query->get('page', 1),
                5
            );
            
            $this->addFlash(
                'message',
                'Cabra abatida com sucesso!',
            );

            $label = 'success';
            
            $dataDoAbate = new \DateTime();
            $goat->setAbatido($dataDoAbate);
            $goatRepository->save($goat, true);

            return $this->render('goat/index.html.twig', [
                'label' => $label,
                'goats' => $pagination,
                'title' => 'Meus animais',
            ]);
        }else{

            $pagination = $paginator->paginate(
            $goatRepository->findByGoatLive(),
            $request->query->get('page', 1),
            5
            );

            $this->addFlash(
                'message',
                'Cabra não atende os requisitos para abate!'
            );

            $label = 'warning';
            
            return $this->render('goat/index.html.twig', [
                'label' => $label,
                'goats' => $pagination,
                'title' => 'Meus animais',
            ]);
        }

               
    }

    
}