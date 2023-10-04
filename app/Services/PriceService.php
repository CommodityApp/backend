<?php

namespace App\Services;

use App\Models\Price;

class PriceService
{
    public function create(array $data, array $priceRaws): Price
    {
        $price = Price::create($data);

        $raws = [];

        foreach ($priceRaws as $key => $priceRaw) {
            $raws[$priceRaw['raw_id']] = ['price' => $priceRaw['price'], 'order_column' => $key + 1];
        }

        $price->raws()->sync($raws);

        return $price;
    }

    public function update(Price $price, array $data, array $priceRaws): Price
    {
        $price->update($data);

        $raws = [];

        foreach ($priceRaws as $key => $priceRaw) {
            $raws[$priceRaw['raw_id']] = ['price' => $priceRaw['price'], 'order_column' => $key + 1];
        }

        $price->raws()->sync($raws);

        return $price;
    }

    public function replicate(Price $price): Price
    {
        $data = $price->attributesToArray();

        unset($data['code']);
        unset($data['id']);

        $priceRaws = [];

        foreach ($price->priceRaws as $priceRaw) {
            $priceRaws[] = ['raw_id' => $priceRaw->raw_id, 'price' => $priceRaw->price];
        }

        return $this->create($data, $priceRaws);
    }

    public function delete(Price $price): Price
    {
        //soft delete
        $price->update(['code' => null]);
        $price->delete();

        return $price;
    }
}
