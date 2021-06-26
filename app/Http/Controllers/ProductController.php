<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseGetRequest;
use App\Http\Requests\BulkUpdateRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\PaginateResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(ProductService $productService)
    {
        $this->serviceInstance = $productService;
    }

    public function create(ProductRequest $request) : JsonResponse {
        $params = $request->validated();

        $data = $this->serviceInstance->create($params);

        return response()->json([
            'message' => 'Created',
            'data' => $data
        ], 201);
    }

    public function get(BaseGetRequest $request) : JsonResponse {
        $data = $this->serviceInstance->get($request->paginate);

        return response()->json(new PaginateResource($data));
    }

    public function update(int $id, ProductRequest $request) : JsonResponse {
        $params = $request->validated();

        $data = $this->serviceInstance->update($id, $params);

        return response()->json([
            'message' => 'Updated',
            'data' => $data
        ], 200);
    }

    public function find(int $id) : JsonResponse {
        return response()->json($this->serviceInstance->find($id));
    }

    public function delete(int $id) : JsonResponse {
        $this->serviceInstance->delete($id);

        return response()->json([
            'message' => 'Deleted'
        ]);
    }

    public function getStockHistory(int $id) : JsonResponse {
        $data = $this->serviceInstance->getStockHistory($id);

        return response()->json($data);
    }

    public function bulkUpdate(BulkUpdateRequest $request) : JsonResponse {
        $data = (object) $request->validated();

        $this->serviceInstance->bulkUpdate($data);

        return response()->json([
            'message' => 'Updated products'
        ]);
    }
}
