<option value="{{ $unit->id }}">{{ $each }}{{ $unit->name }}</option>
@if ($unit->children)
    @php($each .= '-')
    @foreach ($unit->children as $child)
        @include('admin.units.nested-unit', ['unit' => $child])
    @endforeach
@endif