<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\Products\Enums\Category;
use App\Domain\Products\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class APITest extends TestCase
{
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('status')
                ->has('products', Product::count())
                ->has('products.0', fn ($json) =>
                    $json->hasAll(['sku', 'name', 'category', 'price'])
                )
                ->has('products.0.price', fn ($json) =>
                    $json->hasAll(['original', 'final', 'discount_percentage', 'currency'])
                )
        );
    }

    public function test_the_application_can_filter_products_by_category()
    {
        $random_product = Product::all()->random(1)->first();
        $test_category = $random_product->category->value;

        $response = $this->get('/api/products?category=' . $test_category);

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('status')
            ->has('products', Product::where('category', $test_category)->count())
        );

        $response->assertJsonPath('products.0.category', fn ($category) =>
            $category == $test_category
        );
    }

    public function test_the_application_can_filter_products_by_price()
    {
        $random_product = Product::all()->random(1)->first();

        $response = $this->get('/api/products?price=' . $random_product->price);

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('status')
            ->has('products', Product::where('price', $random_product->price)->count())
        );

        $response->assertJsonPath('products.0.price.original', fn ($price) =>
            $price == $random_product->price
        );
    }

    public function test_the_application_returns_422_with_wrong_category_supplied()
    {
        $response = $this->get('/api/products?category=wrong category');

        $response->assertStatus(422);
    }

    public function test_the_application_returns_422_with_wrong_price_supplied()
    {
        $response = $this->get('/api/products?category=wrong price');

        $response->assertStatus(422);
    }

    public function test_the_application_applies_30_percent_discount_for_insurance_products()
    {
        $test_product = Product::where('category', Category::Insurance)->first();

        $response = $this->get('/api/products?category=' . Category::Insurance->value);

        $response->assertStatus(200);

        $response->assertJsonPath('products.0.price.discount_percentage', fn ($discount_percentage) =>
            $discount_percentage == '30%'
        );

        $discount = $test_product->price * 0.3;
        $final_price = $test_product->price - $discount;

        $response->assertJsonPath('products.0.price.final', fn ($final) =>
            $final == $final_price
        );
    }

    public function test_the_application_applies_15_percent_discount_for_products_000003()
    {
        $test_product = Product::where('sku', '000003')->first();

        $response = $this->get('/api/products');

        $response->assertStatus(200);

        $response->assertJsonPath('products.2.price.discount_percentage', fn ($discount_percentage) =>
            $discount_percentage == '15%'
        );

        $response->assertJsonPath('products.2.sku', fn ($sku) =>
            $sku == $test_product->sku
        );

        $discount = $test_product->price * 0.15;
        $final_price = $test_product->price - $discount;

        $response->assertJsonPath('products.2.price.final', fn ($final) =>
            $final == $final_price
        );
    }

    public function test_the_application_does_not_apply_discount_for_vehicle_product_000002()
    {
        $test_product = Product::where('sku', '000002')->first();

        $response = $this->get('/api/products');

        $response->assertStatus(200);

        $response->assertJsonPath('products.1.price.discount_percentage', fn ($discount_percentage) =>
            $discount_percentage == 'null'
        );

        $response->assertJsonPath('products.1.sku', fn ($sku) =>
            $sku == $test_product->sku
        );

        $response->assertJsonPath('products.1.price.final', fn ($final) =>
            $final == $test_product->price
        );
    }
}
