<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Invocelines;
use App\Form\InvoceFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $TVA = 18;
        $invoce = new Facture();
        $line = new Invocelines();
        $invoce->getInvocelines()->add($line);
        $form = $this->createForm(InvoceFormType::class, $invoce);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $lines = $invoce->getInvocelines();
            
            $last_id_record =  $em->getRepository(Facture::class)->findOneBy([], ['id' => 'desc']);
            $invoce->setNumberInvoce($last_id_record ?  (int)$last_id_record->getId() + 1 : 1);
            $em->persist($invoce);
            foreach($lines as $singleLine ){
                $amount_without_vat = $singleLine->getQuantity() * $singleLine->getAmount();
                $amount_vat = ($amount_without_vat * $TVA) / 100;
                $total = $amount_vat + $amount_without_vat;
                $singleLine->setTotal($total);
                $singleLine->setVatAmount($amount_vat);
                $singleLine->setInvoce($invoce);
                $em->persist($singleLine);
            }
            
            $em->flush();
            unset($form);
            unset($invoce);
            unset($line);
            $invoce = new Facture();
            $line = new Invocelines();
            $invoce->getInvocelines()->add($line);
            $form = $this->createForm(InvoceFormType::class, $invoce);
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
