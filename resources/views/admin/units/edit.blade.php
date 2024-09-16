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
                            Sửa đơn vị: {{ $unit->name }}
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

                                <div class="col-lg-12">
                                    <label for="name">Tên đơn vị</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $unit->name }}">
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