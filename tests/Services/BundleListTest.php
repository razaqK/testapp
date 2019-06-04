<?php


namespace App\Tests\Services;


use App\Entity\BundleList;
use App\Services\BundleListService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class BundleListTest extends TestCase
{
    public function testCreateProduct()
    {
        $bundleService = new BundleListService(new BundleList());
        $bundle = $bundleService->create(['bundle_id' => 1, 'product_id' => 1]);


        $this->assertEquals('1', $bundle->bundle_id);
        $this->assertEquals('1', $bundle->getProductId());
    }
}