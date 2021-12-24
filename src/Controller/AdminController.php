<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Produit;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProduitRepository;
use App\Service\ImagesUpload;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{

    private SluggerInterface $slugger;
    private EntityManager $em;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $this->slugger = $slugger;
        $this->em = $em;
    }

    /**
     * @Route("/admin/profile", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/profile.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/category/add", name="admin_add_category")
     */
    public function addCategory(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $categoryName = $form->get('name')->getNormData();
            $category->setSlug($this->slugger->slug($categoryName));
            $this->em->persist($category);
            $this->em->flush();
            $this->addFlash('success', "la catégorie $categoryName a bien été crée");
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/add-category.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function category(CategoryRepository $categoryRepository) {

        $categories = $categoryRepository->findAll();

        return $this->render('admin/category.html.twig', [
            "categories" => $categories
        ]);
    }

    /**
     * @Route("/admin/product/add", name="admin_add_product")
     */
    public function addProduct(Request $request, ImagesUpload $imagesUpload): Response
    {
        $product = new Produit();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $productName = $form->get('name')->getNormData();
            $product->setSlug($this->slugger->slug($productName));
            $imagesUpload->insertImage($product, $form);
            $this->em->persist($product);
            $this->em->flush();

            $this->addFlash('success', "Le produit $productName a bien été ajouté");
            return $this->redirectToRoute("admin");
        }
     
        return $this->render('admin/add-product.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/product", name="admin_product")
     */
    public function product(ProduitRepository $produitRepository) {

        $products = $produitRepository->findAll();

        return $this->render('admin/product.html.twig', [
            "products" => $products
        ]);
    }
}
