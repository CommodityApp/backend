<x-filament-panels::page>
    <div>
        {{ $this->orderInfolist }}
    </div>
    <div>
        @livewire('view-order-calculated-table', ['record' => $record])
    </div>
</x-filament-panels::page>