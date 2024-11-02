<option {{old('parent_id') == $unit->id ? 'selected' : '' }} value="{{ $unit->id }}"> {{$indent}}{{ $unit->name }}</option>

@if ($unit->children)
    @php($indent .= '- ')
    @foreach ($unit->children as $child)
        @include('admin.unit.unit_nested', ['unit' => $child])
    @endforeach
@endif
