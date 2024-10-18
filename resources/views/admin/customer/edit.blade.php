@extends('admin.layouts.master')

@section('title')
    Create Customers
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Customers</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Customers</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('admin.customers.update',$customer) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                              
                                    <div class="col-6">
                                        <div class="mt-3">
                                            <label for="name" class="form-label">Name (<span style="color: rgb(207, 21, 21)">*</span>)</label>
                                            <input type="text" class="form-control @error('name')is-invalid @enderror" name="name" id="name" value="{{$customer->name}}">
                                            <div class="invalid-feedback">
                                                @error('name')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="mt-3">
                                            <label for="phone" class="form-label">Phone (<span style="color: rgb(207, 21, 21)">*</span>)</label>
                                            <input type="number" class="form-control @error('phone')is-invalid @enderror" name="phone" id="phone" value="{{$customer->phone}}">
                                            <div class="invalid-feedback">
                                                @error('phone')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <label for="address" class="form-label">Address (<span style="color: rgb(207, 21, 21)">*</span>)</label>
                                            <input type="text" class="form-control @error('address')is-invalid @enderror" name="address" id="address" value="{{$customer->address}}">
                                            <div class="invalid-feedback">
                                                @error('address')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mt-3">
                                            <label for="email" class="form-label">Email (<span style="color: rgb(207, 21, 21)">*</span>)</label>
                                            <input type="text" class="form-control @error('email')is-invalid @enderror" name="email" id="email" value="{{$customer->email}}">
                                            <div class="invalid-feedback">
                                                @error('email')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <label for="age" class="form-label">Age (<span style="color: rgb(207, 21, 21)">*</span>)</label>
                                            <input type="number" class="form-control @error('age')is-invalid @enderror" name="age" id="age" value="{{$customer->age}}">
                                            <div class="invalid-feedback">
                                                @error('age')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <label for="weight" class="form-label">Weight (<span style="color: rgb(207, 21, 21)">*</span>)</label>
                                            <input type="number" class="form-control @error('weight')is-invalid @enderror" name="weight" id="weight" value="{{$customer->weight}}">
                                            <div class="invalid-feedback">
                                                @error('weight')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--end col-->
        </div>


        <div class="row">
            
            <!--end col-->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex gap-2">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <a class="btn btn-success" href="{{ route('admin.customers.index') }}" class="btn btn-success mb-3">Quay lại</a>
                    </div><!-- end card header -->
                </div>
            </div>
            <!--end col-->
        </div>
    </form>
@endsection


