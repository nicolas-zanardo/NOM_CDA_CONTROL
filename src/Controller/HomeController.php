<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        $products = $produitRepository->findAll();

        return $this->render('shop/home.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="shop_product")
     */
    public function product(string $slug, ProduitRepository $produitRepository): Response
    {
        $product = $produitRepository->findOneBy(['slug' => $slug]);

        return $this->render('shop/product.html.twig', [
           'product' =>  $product
        ]);
    }
}
