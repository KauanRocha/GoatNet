<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GoatRepository;
use Knp\Component\Pager\PaginatorInterface;

class RelatoriosController extends AbstractController
{


    #[Route('/', name: 'index')]
     public function novo(GoatRepository $goatRepository, Request $request, PaginatorInterface $paginator): Response
        {

        $goat = $goatRepository->findByGoatLive();
    
        $youngGoats = [];

        for($i = 0; $i < count($goat); $i++){

            $dataNasc = $goat[$i]->getDataNasc();
            $dataAtual = new \DateTime();

            $diferenca = $dataNasc->diff($dataAtual);
            $idade = $diferenca->y;

            
                if($goat[$i]->getRacaoCons() > 500 and $idade <= 1){
                    array_push($youngGoats, $goat[$i]) ;
                }
            }

        
        $pagination = $paginator->paginate(
            $youngGoats,
            $request->query->get('page', 1),
            5
            
        );
                
            return $this->render('relatorios/index.html.twig', [
                'title' => 'Home',
                'goats' => $pagination,
                'leite' =>$goatRepository->findLeiteSemanal(),
                'racao' => $goatRepository->findRacaoSemanal(),
            ]);
        }

    #[Route('/dead', name: 'goatDead', methods: ['GET'])]

    public function GoatDead(GoatRepository $goatRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
        $goatRepository->findByGoatDead(),
        $request->query->get('page', 1),
        8
        
    );

    return $this->render('relatorios/abatidos.html.twig', [
        'title' => 'Meus animais abatidos',
        'goats' => $pagination,
    ]);

    }

    #[Route('/fordead', name: 'goatForDead', methods: ['GET'])]
    public function goatForDead(GoatRepository $goatRepository, Request $request, PaginatorInterface $paginator): Response
        {
        $goat = $goatRepository->findByGoatLive();
    
        $goatsForKill = [];

        for($i = 0; $i < count($goat); $i++){
                $dataNasc = $goat[$i]->getDataNasc();
                $dataAtual = new \DateTime();

                $diferenca = $dataNasc->diff($dataAtual);
                $idade = $diferenca->y;

            
                    if($goat[$i]->getLeiteProd() < 40){
                        array_push($goatsForKill, $goat[$i]) ;
                    }elseif($goat[$i]->getLeiteProd() < 70 and $goat[$i]->getRacaoCons() > 350){
                        array_push($goatsForKill, $goat[$i]) ;
                    }elseif($idade >= 5){
                        array_push($goatsForKill, $goat[$i]) ;
                    }elseif($goat[$i]->getPeso() > 270){
                        array_push($goatsForKill, $goat[$i]) ;
                    }    
            }

            $pagination = $paginator->paginate(
                $goatsForKill,
                $request->query->get('page', 1),
                8
            );

    return $this->render('relatorios/paraAbate.html.twig', [
        'title' => 'Animais para abate',
        'goats' => $pagination,
    ]);
}

}


    
