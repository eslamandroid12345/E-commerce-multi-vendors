<?php

namespace App\Repository\Eloquent;

use App\Http\Helpers\Http;
use App\Http\Traits\Responser;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductFeatureItem;
use App\Repository\ProductFeatureRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ProductFeatureRepository extends Repository implements ProductFeatureRepositoryInterface
{

    protected Model $model;

    use Responser;


    public function __construct(ProductFeature $model)
    {
        parent::__construct($model);
    }

    public function getAllFeaturesByProductId($productId): Collection|array
    {

        return $this->model::query()
            ->where('product_id','=',$productId)
            ->get();
    }
    public function createProductFeature($product,$featureData): ?Model
    {
        return $this->model::create(['name' => $featureData['name'], 'discrimination' => $featureData['discrimination'], 'quantity' => $featureData['quantity'], 'product_id' => $product->id,]);
    }

    public function updateProductFeature($product,$featureData): bool
    {
        $model = $this->model::findOrFail($featureData['id']);
        return $model->update(['name' => $featureData['name'], 'discrimination' => $featureData['discrimination'],'quantity' => $featureData['quantity'],'product_id' => $product->id,]);
    }


    public function productFeaturesWithDetails($product): Collection|array
    {
        return $this->model::query()
            ->where('product_id',$product->id)
            ->with('details')
            ->get();

    }

    public function productFeaturesWithQuantities($product): Collection|array
    {
        return $this->model::query()
                ->where('product_id', $product->id)
                ->pluck('quantity')
                ->toArray();
    }


    public function deleteOldFeatures($productId)
    {

        try {

            $product = Product::query()->findOrFail($productId);

            DB::table('product_features')
                ->where('product_id','=',$product->id)
                ->delete();

            DB::table('product_feature_items')
                ->where('product_id','=',$product->id)
                ->delete();

        }  catch (ModelNotFoundException $exception) {
            return $this->responseFail(status: Http::NOT_FOUND, message: __('messages.No data found'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }

    }


}
