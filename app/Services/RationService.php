<?php

namespace App\Services;

use App\Models\Ration;

class RationService
{
    public function create(array $data, array $rationRaws): Ration
    {
        $ration = Ration::create($data);

        $raws = [];

        foreach ($rationRaws as $key => $rationRaw) {
            $raws[$rationRaw['raw_id']] = ['ratio' => $rationRaw['ratio'], 'order_column' => $key + 1];
        }

        $ration->raws()->sync($raws);

        return $ration;
    }

    public function update(Ration $ration, array $data, array $rationRaws): Ration
    {
        $ration->update($data);

        $raws = [];

        foreach ($rationRaws as $key => $rationRaw) {
            $raws[$rationRaw['raw_id']] = ['ratio' => $rationRaw['ratio'], 'order_column' => $key + 1];
        }

        $ration->raws()->sync($raws);

        return $ration;
    }

    public function replicate(Ration $ration)
    {
        $data = $ration->attributesToArray();

        unset($data['code']);
        unset($data['id']);

        $rationRaws = [];

        foreach ($ration->rationRaws as $rationRaw) {
            $rationRaws[] = ['raw_id' => $rationRaw->raw_id, 'ratio' => $rationRaw->ratio];
        }

        return $this->create($data, $rationRaws);
    }

    public function delete(Ration $ration): Ration
    {
        //soft delete
        $ration->update(['code' => null]);
        $ration->delete();

        return $ration;
    }
}
