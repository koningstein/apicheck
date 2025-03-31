<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CanvasSetting;

class CanvasSettingSearch extends Component
{
    use WithPagination;

    public $searchApiUrl = '';
    public $searchActive = '';
    public $sortField = 'apiurl';
    public $sortDirection = 'asc';

    protected $queryString = ['sortField', 'sortDirection'];

    public function updatingSearch()
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
        $settings = CanvasSetting::query()
            ->when($this->searchApiUrl, function ($query) {
                $query->where('apiurl', 'like', '%'.$this->searchApiUrl.'%');
            })
            ->when($this->searchActive !== '', function ($query) {
                $query->where('active', $this->searchActive === '1');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.canvas-setting-search', [
            'settings' => $settings,
        ]);
    }
}
