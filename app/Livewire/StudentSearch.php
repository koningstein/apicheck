<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;

class StudentSearch extends Component
{
    use WithPagination;

    public $searchEduarteId = '';
    public $searchCanvasId = '';
    public $filterActive = '';
    public $sortField = 'eduarteid';
    public $sortDirection = 'asc';

    protected $queryString = ['sortField', 'sortDirection', 'filterActive'];

    public function updatingSearchEduarteId()
    {
        $this->resetPage();
    }

    public function updatingSearchCanvasId()
    {
        $this->resetPage();
    }

    public function updatingFilterActive()
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function render()
    {
        $students = Student::query()
            ->when($this->searchEduarteId, function ($query) {
                $query->where('eduarteid', 'like', '%'.$this->searchEduarteId.'%');
            })
            ->when($this->searchCanvasId, function ($query) {
                $query->where('canvasid', 'like', '%'.$this->searchCanvasId.'%');
            })
            ->when($this->filterActive !== '', function ($query) {
                $query->where('isactive', $this->filterActive);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.student-search', [
            'students' => $students,
        ]);
    }
}
