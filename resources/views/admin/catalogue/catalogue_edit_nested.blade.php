@if ($catalog->id != $catalogue->id)
    <option {{ $catalogue->parent_id == $catalog->id ? 'selected' : '' }} value="{{ $catalog->id }}">
        {{ $indent }}{{ $catalog->name }}</option>

    @if ($catalog->children)
        @php($indent .= '- ')
        @foreach ($catalog->children as $child)
            @include('admin.catalogue.catalogue_edit_nested', ['catalog' => $child, 'catalogue' => $catalogue])
        @endforeach
    @endif
@endif
