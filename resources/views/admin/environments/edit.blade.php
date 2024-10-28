@extends('admin.layouts.master')

@section('title')
    Sửa Dữ liệu Môi trường
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Sửa Dữ liệu Môi trường</h4>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.environments.update', $environment->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="mb-3">
                                <label class="form-label" for="real_temperature">Nhiệt độ thực tế</label>
                                <input type="number" class="form-control" id="real_temperature" name="real_temperature" value="{{ old('real_temperature', $environment->real_temperature) }}">
                                @error('real_temperature')
                                    <span class="d-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="real_humidity">Độ ẩm thực tế</label>
                                <input type="number" class="form-control" id="real_humidity" name="real_humidity" value="{{ old('real_humidity', $environment->real_humidity) }}">
                                @error('real_humidity')
                                    <span class="d-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                           
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Card for Displaying Data -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin dữ liệu</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Nhiệt độ từ API:</strong> {{ $environment->temperature }} °C</p>
                            <p><strong>Độ ẩm từ API:</strong> {{ $environment->huminity }} %</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end mb-3">
                <a class="btn btn-primary w-sm" href="{{route('admin.environments.index')}}">Quay lại</a>
                <button type="submit" class="btn btn-success w-sm">Lưu thay đổi</button>
            </div>
        </form>
    </div>
@endsection
