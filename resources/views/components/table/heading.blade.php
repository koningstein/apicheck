{{-- resources/views/components/table/heading.blade.php --}}
<th {{ $attributes->merge(['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider']) }}>
    @unless ($sortable)
        <span>{{ $slot }}</span>
    @else
        <button class="flex items-center space-x-1 group focus:outline-none">
            <span>{{ $slot }}</span>
            <span class="relative flex items-center">
                @if ($direction === 'asc')
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                @elseif ($direction === 'desc')
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                @else
                    <svg class="w-3 h-3 opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                @endif
            </span>
        </button>
    @endunless
</th>
