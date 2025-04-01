<div>
    <div class="p-4 flex-col space-y-4">
        <div class="max-w-full px-2 sm:px-6 lg:px-8 mb-3">
            <div class="flex space-x-2">
                <input type="text" wire:model.live="searchStudent" placeholder="Zoek op Student ID..." class="form-control mb-3 w-full px-3 py-2 border rounded-md bg-gray-200" />
                <input type="text" wire:model.live="searchCrebonr" placeholder="Zoek op Crebo..." class="form-control mb-3 w-full px-3 py-2 border rounded-md bg-gray-200" />
                <input type="text" wire:model.live="searchCohort" placeholder="Zoek op Cohort..." class="form-control mb-3 w-full px-3 py-2 border rounded-md bg-gray-200" />
                <input type="text" wire:model.live="searchStatus" placeholder="Zoek op Status..." class="form-control mb-3 w-full px-3 py-2 border rounded-md bg-gray-200" />
            </div>
        </div>
        <x-table>
            <x-slot name="head">
                <x-table.heading sortable wire:click="sortBy('student_id')" :direction="$sortField === 'student_id' ? $sortDirection : null" class="w-2/12">Student</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('crebo_id')" :direction="$sortField === 'crebo_id' ? $sortDirection : null" class="w-3/12">Crebo</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('cohort_id')" :direction="$sortField === 'cohort_id' ? $sortDirection : null" class="w-2/12">Cohort</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('status_id')" :direction="$sortField === 'status_id' ? $sortDirection : null" class="w-1/12">Status</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('enrollmentdate')" :direction="$sortField === 'enrollmentdate' ? $sortDirection : null" class="w-1/12">Inschrijfdatum</x-table.heading>
                <x-table.heading class="w-1/12">Details</x-table.heading>
                <x-table.heading class="w-1/12">Edit</x-table.heading>
                <x-table.heading class="w-1/12">Delete</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($enrollments as $enrollment)
                    <x-table.row>
                        <x-table.cell class="w-2/12">{{ $enrollment->student->eduarteid }}</x-table.cell>
                        <x-table.cell class="w-3/12">{{ $enrollment->crebo->name }} ({{ $enrollment->crebo->crebonr }})</x-table.cell>
                        <x-table.cell class="w-2/12">{{ $enrollment->cohort->name }}</x-table.cell>
                        <x-table.cell class="w-1/12">{{ $enrollment->status->name }}</x-table.cell>
                        <x-table.cell class="w-1/12">{{ $enrollment->enrollmentdate ? date('d-m-Y', strtotime($enrollment->enrollmentdate)) : 'Niet ingesteld' }}</x-table.cell>
                        <x-table.cell class="w-1/12">
                            <a href="{{ route('admin.enrollments.show', ['enrollment' => $enrollment->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                <i class="fas fa-info-circle mr-1"></i> Details
                            </a>
                        </x-table.cell>
                        <x-table.cell class="w-1/12">
                            <a href="{{ route('admin.enrollments.edit', ['enrollment' => $enrollment->id]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </x-table.cell>
                        <x-table.cell class="w-1/12">
                            <a href="{{ route('admin.enrollments.delete', ['enrollment' => $enrollment->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center text-xs w-full">
                                <i class="fas fa-trash-alt mr-1"></i> Delete
                            </a>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="8">
                            <div class="flex justify-center items-center">
                                <span class="font-medium py-8 text-gray-500 text-xl">Geen inschrijvingen gevonden...</span>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
        <div class="container max-w-full pb-10 flex justify-between items-center px-3">
            <div class="text-xs text-left">
                <p>
                    Showing {{ $enrollments->firstItem() ?? 0 }} to {{ $enrollments->lastItem() ?? 0 }} of {{ $enrollments->total() ?? 0 }} results
                </p>
            </div>
            <div class="text-xs text-right">
                {{ $enrollments->links() }}
            </div>
        </div>
    </div>
</div>
