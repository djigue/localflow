<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private ProduitRepository $productRepository;

    public function __construct(ProduitRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/api/products/{id}', name: 'get_product', methods: ['GET'])]
    public function getProduct(int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            return $this->json(['error' => 'Produit non trouvé'], 404);
        }

        return $this->json([
            'id' => $product->getId(),
            'titre' => $product->getTitre(),
            'prix' => $product->getPrix(),
            'description' => $product->getDescription(),
            'imageUrl' => $product->getImageUrl(),
            'quantity' => $product->getQuantity(),
        ]);
    }
}
