<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\AccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    // ១. ប៊ូតុង Public API (កែត្រង់ shopping_cart)
    public function publicApi()
    {
        $links = [
            'products' => [
                'all_products'    => url('/api/products'),
                'product_detail'  => url('/api/products/19'),
            ],
            'categories' => [
                'list_categories' => url('/api/categories'),
                'products_by_cat' => url('/api/category/9/products'),
            ],
            'shopping_cart' => [
                // កែមកប្រើ /api/cart-data ដើម្បីឱ្យវាទាញទិន្នន័យពី Database ទាំងអស់មកបង្ហាញ
                'view_cart'       => url('/api/cart-data'), 
            ],
            'orders' => [
                'order_list'      => url('/api/orders-list'),
            ]
        ];

        $initialData = \App\Models\Product::with('category')->latest()->take(5)->get();

        $data = [
            'available_endpoints' => $links,
            'preview_data'        => $initialData
        ];

        return view('layouts.admin.api_display', [
            'title'    => 'Public API Interactive Documentation',
            'endpoint' => '/api/public-v1',
            'data'     => $data
        ]);
    }

    // ២. ប៊ូតុង URL List (កែត្រង់ shopping_cart)
    public function urlList()
    {
        $links = [
            'products' => [
                'all_products'    => url('/api/products'),
                'product_detail'  => url('/api/products/19'),
            ],
            'categories' => [
                'list_categories' => url('/api/categories'),
                'products_by_cat' => url('/api/category/9/products'),
            ],
            'shopping_cart' => [
                // កែពី /api/cart មក /api/cart-data វិញដើម្បីបាត់ Error '<' និងឃើញគ្រប់ User
                'view_cart'       => url('/api/cart-data'), 
            ],
            'orders' => [
                'order_list'      => url('/api/orders-list'),
            ]
        ];

        $defaultData = \App\Models\Product::with('category')->latest()->get();

        $data = [
            'api_links' => $links,
            'product_list_data' => $defaultData
        ];

        return view('layouts.admin.api_display', [
            'title'    => 'API Interactive Documentation',
            'endpoint' => '/api/v1/interactive',
            'data'     => $data
        ]);
    }

    // ៣. ប៊ូតុង Access Token (រក្សាទុកដដែល ព្រោះអ្នកបានដាក់ /api/cart-data រួចហើយ)
    public function tokens()
    {
        $tokens = \App\Models\AccessToken::latest()->get();

        $testLinks = [
            'secure_endpoints' => [
                'orders_with_token'         => url('/api/orders-list') . '?Token=123',
                'products_with_token'       => url('/api/products') . '?Token=123',
                'cart_with_token'           => url('/api/cart-data') . '?Token=123',
                'product_by_cat_with_token' => url('/api/category/9/products') . '?Token=123',
            ]
        ];

        $data = [
            'active_access_tokens'   => $tokens,
            'test_interactive_links' => $testLinks,
        ];

        return view('layouts.admin.api_display', [
            'title'    => 'Access Token Management',
            'endpoint' => '/api/access-tokens',
            'data'     => $data
        ]);
    }
}