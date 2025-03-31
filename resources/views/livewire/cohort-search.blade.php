<div>
    <div class="p-4 flex-col space-y-4">
        <div class="max-w-full px-2 sm:px-6 lg:px-8 mb-3">
            <div class="flex space-x-2">
                <input type="text" wire:model.live="searchName" placeholder="Zoek op Naam..." class="form-control mb-3 w-full px-3 py-2 border rounded-md bg-gray-200" />
            </div>
        </div>
        <x-table>
            <x-slot name="head">
                <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null" class="w-5/12">Naam</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('startdate')" :direction="$sortField === 'startdate' ? $sortDirection : null" class="w-2/12">Startdatum</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('enddate')" :direction="$sortField === 'enddate' ? $sortDirection : null" class="w-2/12">Einddatum</x-table.heading>
                <x-table.heading class="w-1/12">Details</x-table.heading>
                <x-table.heading class="w-1/12">Edit</x-table.heading>
                <x-table.heading class="w-1/12">Delete</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($cohorts as $cohort)
                    <x-table.row>
                        <x-table.cell class="w-5/12">{{ $cohort->name }}</x-table.cell>
                        <x-table.cell class="w-2/12">{{ $cohort->startdate ? date('d-m-Y', strtotime($cohort->startdate)) : 'Niet ingesteld' }}</x-table.cell>
                        <x-table.cell class="w-2/12">{{ $cohort->enddate ? date('d-m-Y', strtotime($cohort->enddate)) : 'Niet ingesteld' }}</x-table.cell>
                        <x-table.cell class="w-1/12">
{{--                            @can('show cohort')--}}
                                <a href="{{ route('admin.cohorts.show', ['cohort' => $cohort->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                    <i class="fas fa-info-circle mr-1"></i> Details
                                </a>
{{--                            @endcan--}}
                        </x-table.cell>
                        <x-table.cell class="w-1/12">
{{--                            @can('edit cohort')--}}
                                <a href="{{ route('admin.cohorts.edit', ['cohort' => $cohort->id]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
{{--                            @endcan--}}
                        </x-table.cell>
                        <x-table.cell class="w-1/12">
{{--                            @can('delete cohort')--}}
                                <a href="{{ route('admin.cohorts.delete', ['cohort' => $cohort->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </a>
{{--                            @endcan--}}
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="4">
                            <div class="flex justify-center items-center">
                                <span class="font-medium py-8 text-gray-500 text-xl">Geen cohort gevonden...</span>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
        <div class="container max-w-full pb-10 flex justify-between items-center px-3">
            <div class="text-xs text-left">
                <p>
                    Showing {{ $cohorts->firstItem() }} to {{ $cohorts->lastItem() }} of {{ $cohorts->total() }} results
                </p>
            </div>
            <div class="text-xs text-right">
                {{ $cohorts->links() }}
            </div>
        </div>
    </div>
</div>
