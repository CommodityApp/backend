<?php

namespace App\Services;

use App\Models\Ration;
use App\Models\Receipt;

class RationService
{
    public function create(array $data, array $rationRaws): Ration
    {
        $data['rate'] = Receipt::find($data['receipt_id'])->rate + array_sum(array_filter(array_column($rationRaws, 'ratio')));

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
        $data['rate'] = Receipt::find($data['receipt_id'])->rate + array_sum(array_filter(array_column($rationRaws, 'ratio')));

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
        unset($data['ration_raws_for_resource']);

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
