<!-- catalogue_row.blade.php -->

<tr>
    <td>{{ $catalogue->id }}</td>
    <td>{{ $each }}<a href="#!">{{ $catalogue->name }}</a></td>
    <td>{{ $catalogue->created_at }}</td>
    <td>{{ $catalogue->updated_at }}</td>
    <td>
        <div class="d-flex gap-2">
            <a href="{{route('admin.catalogues.edit', $catalogue->id)}}" class="btn btn-warning">Sửa</a>
            
            <form action="{{route('admin.catalogues.destroy',$catalogue->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa')">Xóa</button>
            </form>
            
        </div>
    </td>
</tr>
@if($catalogue->children)

    @php($each .= "- ")

    @foreach($catalogue->children as $child)

        @include('admin.catalogue.catalogue_row', ['catalogue' => $child])

    @endforeach

@endif
