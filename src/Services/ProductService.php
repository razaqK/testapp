<?php


namespace App\Services;


use App\Entity\BundleList;
use App\Entity\Price;
use App\Entity\Product;

class ProductService
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    public function create(Price $price, $data, $isBundle = false)
    {
        // create product
        $this->product->setName($data['name']);
        $this->product->setDiscountedAmount($price->getDiscountedAmount());
        $this->product->setAmount($price->getAmount());
        $this->product->setCurrency($price->getCurrency());
        $this->product->setIsBundle($isBundle);

        return $this->product;
    }

    public function update(Product $product, Price $price = null, string $name = '')
    {
        $toUpdate = ['name' => $name];
        if (!empty($price)) {
            $toUpdate['amount'] = $price->getAmount();
            $toUpdate['discounted_amount'] = $price->getDiscountedAmount();
            $toUpdate['currency'] = $price->getCurrency();
        }
        return $product->setArrayValueToField($toUpdate, ['id']);
    }

    private function createBundleList(Product $bundle, Product $product)
    {
        $bundleList = new BundleList();
        $bundleList->setBundle($bundle);
        $bundleList->setProductId($product->getId());
        return $bundleList;
    }

    public function addBundle($bundle, $product)
    {
        $bundleList = $this->createBundleList($bundle, $product);
        $this->product->addBundleList($bundleList);
        return $this->product;
    }
}