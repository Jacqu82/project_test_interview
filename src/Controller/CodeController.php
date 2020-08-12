<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\CodeForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Jacek Wesołowski <jacqu25@yahoo.com>
 */
class CodeController extends AbstractController
{
    /**
     * @Route("/generate/code", name="code_generate", methods={"GET","POST"})
     */
    public function generate(Request $request): Response
    {
        $form = $this->createForm(CodeForm::class);
        $form->handleRequest($request);
        $codes = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $quantity = $form->get('quantity')->getData();
            $length = $form->get('length')->getData();
            $codes = $this->generateStringList($quantity, $length);
        }

        return $this->render(
            'code/list.html.twig',
            [
                'codes' => $codes,
                'form' => $form->createView(),
            ]
        );
    }

    private function randomString(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    private function generateStringList(int $quantity = 1, int $length = 15): array
    {
        $list = [];
        for ($i = 1; $i <= $quantity; $i++) {
            $list[] = $this->randomString($length);
        }

        return $list;
    }
}
