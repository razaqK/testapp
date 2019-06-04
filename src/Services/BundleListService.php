<?php


namespace App\Services;


use App\Entity\BundleList;

class BundleListService
{
    private $bundle;

    public function __construct(BundleList $bundle)
    {
        $this->bundle = $bundle;
    }

    public function create($data)
    {
        $toAdd = [
            'bundle_id' => $data['bundle_id'],
            'product_id' => $data['product_id'],
        ];
        return $this->bundle->setArrayValueToField($toAdd);
    }
}