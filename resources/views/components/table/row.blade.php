{{-- resources/views/components/table/row.blade.php --}}
<tr {{ $attributes->merge(['class' => 'hover:bg-gray-100 bg-white']) }}>
    {{ $slot }}
</tr>
