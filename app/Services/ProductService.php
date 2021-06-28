<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseService {
    public function __construct(Product $product)
    {
        $this->modelInstance = $product;
    }

    public function create(array $params) : Product {
        return $this->modelInstance->create($params);
    }

    public function get(object $params) : LengthAwarePaginator {
        $params->order_field ??= 'id';
        $params->order ??= 'asc';
        $params->paginate ??= 20;

        $data = $this->modelInstance
        ->orderBy($params->order_field, $params->order)
        ->when(isset($params->search), function($w) use($params) {
            $w->where('name', 'like', "%$params->search%")
            ->orWhere('description', 'like', "%$params->search%");
        })
        ->paginate($params->paginate);

        return $data;
    }

    public function update(int $id, array $params) : Product {
        $model = $this->modelInstance->findOrFail($id);

        $model->update($params);

        return $model;
    }

    public function find(int $id) : Product {
        return $this->modelInstance->findOrFail($id);
    }

    public function delete(int $id) : bool {
        return $this->modelInstance->findOrFail($id)->delete();
    }

    public function getStockHistory(int $id) : Collection {
        $product = $this->modelInstance->findOrFail($id);

        $history = $product->stockHistory->sortByDesc('created_at')->values();

        return $history;

    }

    public function bulkUpdate(object $params) : bool {
        $updatableItems = [];

        if (isset($params->stock_quantity)) $updatableItems['stock_quantity'] = $params->stock_quantity;
        if (isset($params->price)) $updatableItems['price'] = $params->price;

        // used foreach instead massive update to trigger the Product model hook to set stock history
        DB::transaction(function () use($params, $updatableItems) {
            foreach ($params->products as $product) {
                $productInstance = $this->modelInstance->findOrFail($product);

                $productInstance->update($updatableItems);
            }
        });

        return true;
    }
}
