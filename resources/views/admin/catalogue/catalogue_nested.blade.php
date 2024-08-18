<option {{old('parent_id') == $catalog->id ? 'selected' : '' }} value="{{ $catalog->id }}"> {{$indent}}{{ $catalog->name }}</option>

@if ($catalog->children)
    @php($indent .= '- ')
    @foreach ($catalog->children as $child)
        @include('admin.catalogue.catalogue_nested', ['catalog' => $child])
    @endforeach
@endif
