<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\CodeForm;
use App\Provider\CodeProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Jacek Wesołowski <jacqu25@yahoo.com>
 */
class CodeController extends AbstractController
{
    private $codeProvider;

    public function __construct(CodeProvider $codeProvider)
    {
        $this->codeProvider = $codeProvider;
    }

    /**
     * @Route("/generate/code", name="code_generate", methods={"GET","POST"})
     */
    public function generate(Request $request): Response
    {
        $form = $this->createForm(CodeForm::class);
        $form->handleRequest($request);
        $codes = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $codes = $this->codeProvider->generateRandomCodeList(
                $form->get('length')->getData(),
                $form->get('quantity')->getData(),
                $form->get('type')->getData()
            );
        }

        return $this->render(
            'code/list.html.twig',
            [
                'codes' => $codes,
                'form' => $form->createView(),
            ]
        );
    }
}
