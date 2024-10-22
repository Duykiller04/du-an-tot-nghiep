@extends('admin.layouts.master')

@section('title')
    Thêm Môi Trường
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Thêm Môi Trường</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Môi Trường</a></li>
                            <li class="breadcrumb-item active">Thêm Môi Trường</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        @if ($errors->any())
             {{-- @dd($errors); --}}
            <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
        @endif

        <form id="create-environment-form" method="POST" action="{{ route('admin.environments.store') }}">
            @csrf
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin chung</h5>
                        </div>
                        <div class="card-body">
                            

                            <div class="mb-3">
                                <label class="form-label" for="real_temperature">Nhiệt độ trong kho<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                <input type="number" step="0.01" class="form-control" id="real_temperature" name="real_temperature" value="{{ old('real_temperature') }}">
                                @error('real_temperature')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-sm-6">
                                <label class="form-label" for="real_temperature">Nhiệt độ môi trường<span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="real_temperature" name="temperature" value="{{ $weatherData['main']['temp']}}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                
                                <label class="form-label" for="real_humidity">Độ ẩm thực tế<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                <input type="number" step="0.01" class="form-control" id="real_humidity" name="real_humidity" value="{{ old('real_humidity') }}">
                                @error('real_humidity')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="real_temperature">Độ ẩm theo thời tiết<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                <input type="number" step="0.01" class="form-control" id="real_temperature" name="huminity" value="{{ $weatherData['main']['humidity'] }}" readonly>
                                </div>
                            </div>
                           
                            
                            
                        </div>
                    </div>
                </div>
    
                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">Thông tin theo kho</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="storage_id">Chọn kho</label>
                                <select class="form-select" id="storage_id" name="storage_id">
                                    @foreach($storages as $storage)
                                        <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                    @endforeach
                                </select>
                                @error('storage_id')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
            </div>

            <div class="text-start mb-3">
                <a class="btn btn-primary" href="{{route('admin.environments.index')}}">Quay lại</a>
                <button type="submit" class="btn btn-success w-sm">Lưu môi trường</button>
            </div>
        </form>
    </div>
@endsection

@section('script-libs')
    <script>
        
           
    </script>
@endsection