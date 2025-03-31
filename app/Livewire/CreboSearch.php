<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Crebo;

class CreboSearch extends Component
{
    use WithPagination;

    public $searchName = '';
    public $searchCrebonr = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $queryString = ['sortField', 'sortDirection'];

    #[On('searchUpdated')]
    public function updatingSearch()
    {
//        dd('Search is being updated'); // Voeg deze regel toe voor debugging
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if($this->sortField === $field)
        {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }else{
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function render()
    {
        $crebos = Crebo::query()
            ->when($this->searchName, function ($query) {
                $query->where('name', 'like', '%'.$this->searchName.'%');
            })
            ->when($this->searchCrebonr, function ($query) {
                $query->where('crebonr', 'like', '%'.$this->searchCrebonr.'%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
//        $crebos = Crebo::search($this->search)->paginate(10);

        return view('livewire.crebo-search', [
            'crebos' => $crebos,
        ]);
    }
}
