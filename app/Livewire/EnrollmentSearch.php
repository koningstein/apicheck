<?php

namespace App\Livewire;

use App\Models\Enrollment;
use Livewire\Component;
use Livewire\WithPagination;

class EnrollmentSearch extends Component
{
    use WithPagination;

    public $searchStudent = '';
    public $searchCrebonr = '';
    public $searchCohort = '';
    public $searchStatus = '';
    public $sortField = 'enrollmentdate';
    public $sortDirection = 'desc';

    protected $queryString = ['sortField', 'sortDirection'];

    public function updatingSearchStudent()
    {
        $this->resetPage();
    }

    public function updatingSearchCrebonr()
    {
        $this->resetPage();
    }

    public function updatingSearchCohort()
    {
        $this->resetPage();
    }

    public function updatingSearchStatus()
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
        $enrollments = Enrollment::query()
            ->with(['student', 'crebo', 'cohort', 'status'])
            ->when($this->searchStudent, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('eduarteid', 'like', '%'.$this->searchStudent.'%');
                });
            })
            ->when($this->searchCrebonr, function ($query) {
                $query->whereHas('crebo', function ($q) {
                    $q->where('crebonr', 'like', '%'.$this->searchCrebonr.'%')
                        ->orWhere('name', 'like', '%'.$this->searchCrebonr.'%');
                });
            })
            ->when($this->searchCohort, function ($query) {
                $query->whereHas('cohort', function ($q) {
                    $q->where('name', 'like', '%'.$this->searchCohort.'%');
                });
            })
            ->when($this->searchStatus, function ($query) {
                $query->whereHas('status', function ($q) {
                    $q->where('name', 'like', '%'.$this->searchStatus.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.enrollment-search', [
            'enrollments' => $enrollments,
        ]);
    }
}
