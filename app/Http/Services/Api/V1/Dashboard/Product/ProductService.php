<?php

namespace App\Http\Services\Api\V1\Dashboard\Product;
use App\Http\Helpers\Http;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Requests\Api\V1\Dashboard\Product\UpdateimageRequest;
use App\Http\Requests\Api\V1\Dashboard\Product\UpdateProductRequest;
use App\Http\Resources\V1\Dashboard\Admin\Seller\SellerSelectResource;
use App\Http\Resources\V1\Dashboard\Product\ProductCollection;
use App\Http\Resources\V1\Dashboard\Product\ProductShowResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Http\Services\Mutual\GetService;
use App\Repository\AuthRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Repository\ProductRepositoryInterface;
use App\Repository\ProductImageRepositoryInterface;
use App\Http\Requests\Api\V1\Dashboard\Product\StoreProductRequest;
use App\Http\Resources\V1\Dashboard\Product\ProductResource;
use Illuminate\Support\Facades\DB;


class ProductService
{
    protected ProductRepositoryInterface $productRepository;
    protected ProductImageRepositoryInterface $productImageRepository;
    protected FileManagerService $fileManagerService;
    protected GetService $getService;


    use Responser;

    protected AuthRepositoryInterface $authRepository;

    public function __construct(ProductRepositoryInterface $productRepository, ProductImageRepositoryInterface $productImageRepository, GetService $getService,FileManagerService $fileManagerService,AuthRepositoryInterface $authRepository)
    {
        $this->productRepository = $productRepository;
        $this->productImageRepository = $productImageRepository;
        $this->getService = $getService;
        $this->fileManagerService = $fileManagerService;
        $this->authRepository = $authRepository;

    }

    public function  index(): JsonResponse
    {
        return $this->getService->handle(resource: ProductCollection::class,repository: $this->productRepository,method: 'getAllProducts', is_instance: true, message: __('dashboard_api.show_successfully'));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $product = $this->createProduct($request);//store product data
            $this->uploadImages($request, $product);//store images for product
            DB::commit();
            return $this->responseSuccess(Http::OK, __('messages.created successfully'),data: new ProductResource($product));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
    protected function createProduct(StoreProductRequest $request): ?Model
    {
        $data = $request->except(['images']);
        $product = $this->productRepository->create($data);
        $this->productRepository->multipleLanguages($product, $request, ['name', 'description']);
        return $product;
    }

    protected function uploadImages(StoreProductRequest $request, $product): void
    {
        if ($request->hasFile('images'))
        {
            foreach ($request->images as $index => $image)
            {
                $newImage = $this->fileManagerService->handle("images.$index", "product/images");
                $this->productImageRepository->create(['image' => $newImage, 'product_id' => $product->id]);
            }
        }
    }

    public function show($id): JsonResponse
    {
        return $this->getService->handle(resource: ProductShowResource::class , repository: $this->productRepository,method:'getById',parameters:[$id],is_instance:true,message: __('dashboard_api.show_successfully'));
    }

    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $product = $this->productRepository->getById($id);
            $this->updateProduct($request, $product);
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (ModelNotFoundException $exception)
        {
            return $this->responseFail(status: Http::NOT_FOUND, message: __('messages.No data found'));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    protected function updateProduct(UpdateProductRequest $request, $product): void
    {
        $data = $request->only('product_code', 'tags', 'category_id', 'sub_category_id', 'brand_id', 'seller_id','discount','is_active');
        $this->productRepository->update($product->id, $data);
        $this->productRepository->multipleLanguages($product, $request, ['name', 'description']);
        $this->updateImages($request, $product);
    }

    protected function updateImages(UpdateProductRequest $request, $product): void
    {
        if ($request->hasFile('images'))
        {
            $this->deleteExistingImages($product);
            $this->storeNewImages($request, $product);
        }
    }

    protected function deleteExistingImages($product): void
    {
        foreach ($product->images as $image)
        {
            $this->fileManagerService->deleteFile($image->image);
            $image->delete();
        }
    }

    protected function storeNewImages(UpdateProductRequest $request, $product): void
    {
        if ($request->hasFile('images'))
        {
            foreach ($request->images as $index => $image)
            {
                $newImage = $this->fileManagerService->handle("images.$index", "product/images");
                $this->productImageRepository->create(['image' => $newImage, 'product_id' => $product->id]);
            }
        }
    }

    public function destroy($id): JsonResponse
    {
        try
        {
            $product = $this->productRepository->getById($id);
            $this->deleteProductImages($product);
            $this->productRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    protected function deleteProductImages($product): void
    {
        foreach ($product->images as $image)
        {
            $this->deleteImageAndRecord($image);
        }
    }

    protected function deleteImageAndRecord($image): void
    {
        $this->fileManagerService->deleteFile($image->image);
        $this->productImageRepository->delete($image->id);
    }


    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {
        $product = $this->productRepository->getById($id);
        $this->productRepository->update($product->id,['is_active' => $request->is_active]);
        return $this->responseSuccess(Http::OK,__('dashboard_api.updated_successfully'));
    }

    public function sellers(): JsonResponse
    {
        return $this->getService->handle(resource: SellerSelectResource::class ,repository: $this->authRepository,method:'get',parameters:['user_type','seller'],message:__('dashboard_api.show_successfully'));
    }

    public function deleteImage($id): JsonResponse
    {

        try
        {
            $productImage = $this->productImageRepository->getById($id);
            $product = $this->productRepository->getById($productImage->product_id);
            $this->deleteImageAndRecord($productImage);
            if($product->images->count() == 1)
            {
                $this->productImageRepository->create(['image' => 'storage/product/images/product.jpg' , 'product_id' => $product->id]);
            }
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function updateImage(UpdateimageRequest $request,$id): JsonResponse
    {
        try
        {
            $product = $this->productRepository->getById($id);
            if ($request->hasFile('images'))
            {
                foreach ($request->images as $index => $image)
                {
                    $newImage = $this->fileManagerService->handle("images.$index", "product/images");
                    $this->productImageRepository->create(['image' => $newImage, 'product_id' => $product->id]);
                }
            }
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
