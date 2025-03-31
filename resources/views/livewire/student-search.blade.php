<div>
    <div class="p-4 flex-col space-y-4">
        <div class="max-w-full px-2 sm:px-6 lg:px-8 mb-3">
            <div class="flex space-x-2">
                <input type="text" wire:model.live="searchEduarteId" placeholder="Zoek op Eduarte ID..." class="form-control mb-3 w-full px-3 py-2 border rounded-md bg-gray-200" />
                <input type="text" wire:model.live="searchCanvasId" placeholder="Zoek op Canvas ID..." class="form-control mb-3 w-full px-3 py-2 border rounded-md bg-gray-200" />
                <select wire:model.live="filterActive" class="form-control mb-3 px-3 py-2 border rounded-md bg-gray-200">
                    <option value="">Alle studenten</option>
                    <option value="1">Alleen actieve</option>
                    <option value="0">Alleen inactieve</option>
                </select>
            </div>
        </div>
        <x-table>
            <x-slot name="head">
                <x-table.heading sortable wire:click="sortBy('eduarteid')" :direction="$sortField === 'eduarteid' ? $sortDirection : null" class="w-3/12">Eduarte ID</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('canvasid')" :direction="$sortField === 'canvasid' ? $sortDirection : null" class="w-3/12">Canvas ID</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('isactive')" :direction="$sortField === 'isactive' ? $sortDirection : null" class="w-2/12">Status</x-table.heading>
                <x-table.heading class="w-1/12">Details</x-table.heading>
                <x-table.heading class="w-1/12">Edit</x-table.heading>
                <x-table.heading class="w-1/12">Delete</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($students as $student)
                    <x-table.row>
                        <x-table.cell class="w-3/12">{{ $student->eduarteid }}</x-table.cell>
                        <x-table.cell class="w-3/12">{{ $student->canvasid ?? 'Niet ingesteld' }}</x-table.cell>
                        <x-table.cell class="w-2/12">
                            <span class="px-2 py-1 rounded {{ $student->isactive ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $student->isactive ? 'Actief' : 'Inactief' }}
                            </span>
                        </x-table.cell>
                        <x-table.cell class="w-1/12">
                            <a href="{{ route('admin.students.show', ['student' => $student->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                <i class="fas fa-info-circle mr-1"></i> Details
                            </a>
                        </x-table.cell>
                        <x-table.cell class="w-1/12">
                            <a href="{{ route('admin.students.edit', ['student' => $student->id]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </x-table.cell>
                        <x-table.cell class="w-1/12">
                            <a href="{{ route('admin.students.delete', ['student' => $student->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                <i class="fas fa-trash-alt mr-1"></i> Delete
                            </a>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="6">
                            <div class="flex justify-center items-center">
                                <span class="font-medium py-8 text-gray-500 text-xl">Geen studenten gevonden...</span>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
        <div class="container max-w-full pb-10 flex justify-between items-center px-3">
            <div class="text-xs text-left">
                <p>
                    Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results
                </p>
            </div>
            <div class="text-xs text-right">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>
