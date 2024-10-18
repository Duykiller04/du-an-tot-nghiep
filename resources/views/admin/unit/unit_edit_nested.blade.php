@if ($unit_item->id != $unit->id)
    <option {{ $unit->parent_id == $unit_item->id ? 'selected' : '' }} value="{{ $unit->id }}">
        {{ $indent }}{{ $unit_item->name }}
    </option>

    @if ($unit_item->children)
        @php($indent .= '- ')
        @foreach ($unit_item->children as $child)
            @include('admin.unit.unit_nested', ['unit_item' => $child])
        @endforeach
    @endif
@endif
