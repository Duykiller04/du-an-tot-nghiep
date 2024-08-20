@extends('admin.layouts.master')

@section('title')
    Sửa đơn vị tính {{ $unit->name }}
@endsection

@section('content')


    <form action="{{ route('admin.units.update', $unit) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Sửa danh loại tin: {{ $unit->name }}
                        </h4>
                    </div>
                    <!-- end card header -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-lg-4">
                                    <label for="name">Tên loại tin</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $unit->name }}">
                                </div>

                                <div class="col-lg-4">
                                    <label for="parent_id" class="form-label">Loại tin cha</label>
                                    <select id="" class="js-example-basic-single form-control" name="parent_id"
                                        id="parent_id">
                                        @php($parent_id = $unit->parent_id)
                                        @foreach ($parentUnits as $parent)
                                            @php($each = ' ')
                                            @include('admin.units.nested-unit-edit', [
                                                'unit' => $parent,
                                                'parent_id' => $parent_id,
                                            ])
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Sửa</button>
                                </div>

                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
    </form>
@endsection