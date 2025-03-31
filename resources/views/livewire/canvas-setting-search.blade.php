<div>
    <div class="p-4 flex-col space-y-4">
        <div class="max-w-full px-2 sm:px-6 lg:px-8 mb-3">
            <div class="flex space-x-2">
                <input type="text" wire:model.live="searchApiUrl" placeholder="Zoek op API URL..." class="form-control mb-3 w-full px-3 py-2 border rounded-md bg-gray-200" />
                <select wire:model.live="searchActive" class="form-control mb-3 px-3 py-2 border rounded-md bg-gray-200">
                    <option value="">Alle statussen</option>
                    <option value="1">Actief</option>
                    <option value="0">Inactief</option>
                </select>
            </div>
        </div>
        <x-table>
            <x-slot name="head">
                <x-table.heading sortable wire:click="sortBy('apiurl')" :direction="$sortField === 'apiurl' ? $sortDirection : null" class="w-6/12">API URL</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('active')" :direction="$sortField === 'active' ? $sortDirection : null" class="w-2/12">Status</x-table.heading>
                <x-table.heading class="w-1/12">Details</x-table.heading>
                <x-table.heading class="w-1/12">Edit</x-table.heading>
                <x-table.heading class="w-1/12">Delete</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($settings as $setting)
                    <x-table.row>
                        <x-table.cell class="w-6/12">{{ $setting->apiurl }}</x-table.cell>
                        <x-table.cell class="w-2/12">
                            <span class="px-2 py-1 rounded text-white text-xs {{ $setting->active ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $setting->active ? 'Actief' : 'Inactief' }}
                            </span>
                        </x-table.cell>
                        <x-table.cell class="w-1/12">
                            <a href="{{ route('admin.canvas-settings.show', ['canvas_setting' => $setting->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                <i class="fas fa-info-circle mr-1"></i> Details
                            </a>
                        </x-table.cell>
                        <x-table.cell class="w-1/12">
                            <a href="{{ route('admin.canvas-settings.edit', ['canvas_setting' => $setting->id]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </x-table.cell>
                        <x-table.cell class="w-1/12">
                            <a href="{{ route('admin.canvas-settings.delete', ['canvas_setting' => $setting->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                <i class="fas fa-trash-alt mr-1"></i> Delete
                            </a>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="5">
                            <div class="flex justify-center items-center">
                                <span class="font-medium py-8 text-gray-500 text-xl">Geen Canvas instellingen gevonden...</span>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
        <div class="container max-w-full pb-10 flex justify-between items-center px-3">
            <div class="text-xs text-left">
                @if($settings->count() > 0)
                    <p>
                        Showing {{ $settings->firstItem() }} to {{ $settings->lastItem() }} of {{ $settings->total() }} results
                    </p>
                @endif
            </div>
            <div class="text-xs text-right">
                {{ $settings->links() }}
            </div>
        </div>
    </div>
</div>
