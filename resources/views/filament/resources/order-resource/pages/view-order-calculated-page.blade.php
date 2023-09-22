<x-filament-panels::page>
    <div>
        {{ $this->orderInfolist }}
    </div>
    <div>
        <x-filament::tabs label="Content tabs">
            @foreach ($record->batch_inputs as $key => $input)
            <x-filament::tabs.item :active="$activeTab === $key" wire:click="updateTab({{ $key }})">
                {{$input}}
            </x-filament::tabs.item>
            @endforeach
        </x-filament::tabs>
    </div>
    <div>
        <livewire:view-order-calculated-table :$record :index="$activeTab" />
    </div>
</x-filament-panels::page>