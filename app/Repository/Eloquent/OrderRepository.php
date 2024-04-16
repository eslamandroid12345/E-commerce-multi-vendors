<?php

namespace App\Repository\Eloquent;

use App\Models\Order;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends Repository implements OrderRepositoryInterface
{
    protected Model $model;

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function getAllOrders(): LengthAwarePaginator
    {
        return $this->model::query()
            ->when(request()->has('order_status') && request('order_status') !== null, function ($q) {
                $q->where('order_status', request('order_status'));
            })
            ->when(request()->has('payment_gateway') && request('payment_gateway') != null, function ($q)  {
                $q->where('payment_gateway', request('payment_gateway'));
            })
            ->when(request()->has('placed_date') && request('placed_date') != null, function ($q)  {
                $formattedPlacedDate = date('Y-m-d', strtotime(request('placed_date')));
                $q->whereDate('created_at', $formattedPlacedDate);
            })
            ->when(request()->has('price_from') && request()->has('price_to') && request('price_from') != null && request('price_to') != null, function ($query) {
                $query->whereBetween('grand_total', [request('price_from'), request('price_to')]);
            })
            ->when(request()->has('rank') && request('rank') != null, function ($q)  {
                $q->orderBy('created_at', request('rank') == 1 ? 'asc' : 'desc');
            })
            ->latest()
            ->select(['*'])
            ->paginate(10);
    }


    public function getOrdersSeller($id): LengthAwarePaginator
    {
        return $this->model::query()
            ->whereRelation('details','seller_id','=',$id)
            ->when(request()->has('order_status') && request('order_status') !== '', function ($q) {
                $q->where('order_status', request('order_status'));
            })
            ->when(request()->has('payment_gateway') && request('payment_gateway') != null, function ($q)  {
                $q->where('payment_gateway', request('payment_gateway'));
            })
            ->when(request()->has('placed_date') && request('placed_date') != null, function ($q)  {
                $formattedPlacedDate = date('Y-m-d', strtotime(request('placed_date')));
                $q->whereDate('created_at', $formattedPlacedDate);
            })
            ->when(request()->has('price_from') && request()->has('price_to') && request('price_from') != null && request('price_to') != null, function ($query) {
                $query->whereBetween('grand_total', [request('price_from'), request('price_to')]);
            })
            ->latest()->select(['*'])->paginate(10);
    }

    public function filter($category_id=null,$brand_id=null,$status=null,$placed_date=null,$payment_gateway=null,$price_from=null,$price_to=null) : LengthAwarePaginator
    {
        return $this->model::query()
            ->when($status, function ($query, $status) {
                $query->where('order_status', $status);
            })
            ->when($payment_gateway, function ($query, $payment_gateway) {
                $query->where('payment_gateway', $payment_gateway);
            })
            ->when($placed_date, function ($query, $placed_date) {
                $formattedPlacedDate = date('Y-m-d', strtotime($placed_date));
                $query->whereDate('created_at', $formattedPlacedDate);
            })
            ->when($price_from && $price_to, function ($query) use ($price_from, $price_to) {
                $query->whereBetween('grand_total', [$price_from, $price_to]);
            })
            ->paginate(10);
    }

}
