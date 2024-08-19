<option value="{{ $unit->id }}" @if ($parent_id == $unit->id) selected @endif>
    {{ $each }}{{ $unit->name }}</option>
@if ($unit->children)
    @php($each .= '-')
    @foreach ($unit->children as $child)
        @include('admin.units.nested-unit-edit', ['unit' => $child])
    @endforeach
@endif