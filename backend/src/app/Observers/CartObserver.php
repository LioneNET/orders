<?php

namespace App\Observers;

class CartObserver
{
    public function updated($model)
    {
        if ($model->isDirty('quantity')) {
            $this->quantityComputed($model);
        }
    }

    public function created($model)
    {
        $this->quantityComputed($model);
    }

    public function deleted($model)
    {
        $this->quantityComputed($model);
    }

    /**
     * Расчитываем количество товара
     * @param $model
     * @param bool $is_subtract
     * @return void
     */
    private function quantityComputed($model)
    {
        $quantity = $model->isDirty('quantity') ? $model->getOriginal('quantity') - $model->quantity : $model->quantity;
        $product = $model->product;
        $product->quantity = max($product->quantity + $quantity, 0);
        $product->save();
    }
}
