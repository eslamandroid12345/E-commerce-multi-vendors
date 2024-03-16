<?php

namespace App\Http\Controllers\Api\V1\Site\Cart;
use App\Http\Requests\Api\V1\Site\Cart\CartRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Site\Cart\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart(CartRequest $request)
    {
        return $this->cartService->addToCart($request);
    }

    public function updateItemCart($id,CartRequest $request)
    {
        return $this->cartService->updateItemCart($id,$request);
    }

    public function deleteFromCart($id)
    {
        return $this->cartService->deleteFromCart($id);
    }

    public function deleteAllFromCart(Request $request)
    {
        return $this->cartService->deleteAllFromCart($request);
    }

    public function getAllItems()
    {
        return $this->cartService->getAllItems();
    }
}
