<?php


namespace App\Controller;


use App\Constant\Messages;
use App\Entity\Product;
use App\Services\AmountService;
use App\Services\BundleListService;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends BaseController
{
    private $productService;
    private $amountService;
    private $bundleListService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     * @param AmountService $discountService
     * @param BundleListService $bundleListService
     */
    public function __construct(ProductService $productService, AmountService $discountService, BundleListService $bundleListService)
    {
        $this->amountService = $discountService;
        $this->productService = $productService;
        $this->bundleListService = $bundleListService;
    }

    /**
     * @param $data
     * @param $isBundle
     * @return Product
     */
    private function createProduct(array $data, bool $isBundle) : Product
    {
        $price = $this->amountService->preparePrice($data['price'], $data['discount']);

        $product = $this->productService->create($price, $data, $isBundle);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();
        return $product;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $validator = $this->validateParameters($data, ['name' => 'required', 'price' => 'required', 'discount' => 'required']);
        if (!$validator['status']) {
            return $this->sendError($validator['message'], 400, $validator['data']);
        }

        $product = $this->createProduct($data, false);


        return $this->sendSuccess(['id' => $product->getId(), 'discounted_amount' => $product->getDiscountedAmount()], 201, sprintf(Messages::CREATED, 'product'));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function createBundle(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $validator = $this->validateParameters($data, ['name' => 'required', 'price' => 'required', 'discount' => 'required', 'products' => 'required']);
        if (!$validator['status']) {
            return $this->sendError($validator['message'], 400, $validator['data']);
        }

        $price = $this->amountService->preparePrice($data['price'], $data['discount']);

        $bundle = $this->productService->create($price, $data, true);

        //$bundle = $this->createProduct($data, true);
        foreach ($data['products'] as $productId) {
            $product= $this->getDoctrine()->getManager()
                ->getRepository(Product::class)->find($productId);
            if (!$product) {
                return $this->sendError(sprintf(Messages::NOT_FOUND, 'product'), 404);
            }
            $this->productService->addBundle($bundle, $product);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($bundle);
        $entityManager->flush();


        return $this->sendSuccess(['id' => $bundle->getId(), 'discounted_amount' => $bundle->getDiscountedAmount()], 201, sprintf(Messages::CREATED, 'bundle'));
    }

    /**
     * @param Request $request
     * @return mixed|object
     */
    public function getProducts(Request $request)
    {
        $page = $request->get('page');
        $limit = $request->get('limit');

        $page = !empty($page) ? $page : 0;
        $limit = !empty($limit) ? $limit : 20;

        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAllRecords($page, $limit);
        if (!$product) {
            return $this->sendError(sprintf(Messages::NOT_FOUND, 'record'),  404);
        }
        return $this->sendSuccess($product);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed|object
     */
    public function getSingleProduct(Request $request, $id)
    {
        $product = $this->getDoctrine()->getManager()
            ->getRepository(Product::class)->find($id);
        if (!$product) {
            return $this->sendError(sprintf(Messages::NOT_FOUND, 'product'), 404);
        }

        return $this->sendSuccess($product->toArray());
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed|object
     */
    public function updateProduct(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getManager()
            ->getRepository(Product::class)->find($id);
        if (!$product) {
            return $this->sendError(sprintf(Messages::NOT_FOUND, 'product'), 404);
        }
        $data = json_decode($request->getContent(), true);
        $name = !empty($data['name']) ? $data['name'] : '';
        if (!empty($data['price'])) {
            $discount = !empty($data['discount']) ? $data['discount'] : 0;
            $price = $this->amountService->preparePrice($data['price'], $discount);
        }
        $product = $this->productService->update($product, $price, $name);
        $entityManager->flush();
        return $this->sendSuccess($product);
    }
}