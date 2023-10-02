<?php

namespace App\Services;

use App\Models\Raw;

class RawService
{
    public function create(array $data)
    {
        return Raw::create($data);
    }

    public function update(Raw $raw, $data)
    {
        $raw->update($data);
        return $raw;
    }

    public function delete(Raw $raw)
    {
        $raw->update(['code' => null]);
        $raw->delete();

        return $raw;
    }
}
