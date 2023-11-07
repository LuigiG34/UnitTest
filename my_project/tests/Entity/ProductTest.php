<?php

namespace App\Tests\Entity;

use App\Entity\Product;

class ProductTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider pricesForFoodProduct
     */
    public function testComputeTVAFoodProduct($price, $expectedTva)
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, $price);
        $this->assertSame($expectedTva, $product->computeTVA());
    }

    public function pricesForFoodProduct()
    {
        return [
            [0, 0.0],
            [20, 1.1],
            [100, 5.5]
        ];
    }

    public function testComputeTVAOtherProduct()
    {
        $product = new Product('Une télévision', 'Un autre type de produit', 20);
        $this->assertSame(3.92, $product->computeTVA());
    }

    public function testNegativePriceComputeTVA()
    {
        $product = new Product('Un produit ayant un pris négatif', Product::FOOD_PRODUCT, -20);
        $this->expectException('\Exception');
        $product->computeTVA();
    }
}
