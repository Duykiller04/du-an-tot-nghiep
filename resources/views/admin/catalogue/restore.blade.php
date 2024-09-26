<!-- index.blade.php -->

@extends('admin.layouts.trash')

@section('title')
    Danh sách danh mục đã xóa
@endsection

@section('content')




    <div class="row">
        <div class="col-lg-12">
            <div class="card">

  
                <div class="card-body">
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="today" role="tabpanel">
                            <div class="profile-timeline">
                                <div class="accordion accordion-flush" id="todayExample">
                                    <!-- start page title -->
                                    <h4>Danh mục đã xóa</h4>
                                <!-- end page title -->
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">

                                                
                                        
                                                @if (session('success'))
                                                    <div class="alert alert-success mb-3">
                                                        {{ session('success') }}
                                                    </div>
                                                @endif
                                        
                                            <thead class="table-light">
                                                <form action="{{ route('admin.restore.categories') }}" method="POST">
                                                    @csrf
                                                    <table id="example"
                                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="select-all"></th>
                                                                <th>Mã danh mục</th>
                                                                <th>Tên danh mục</th>
                                                                <th>Ngày xóa</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($data as $category)
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" name="ids[]"
                                                                            value="{{ $category->id }}">
                                                                    </td>
                                                                    <td>{{ $category->id }}</td>
                                                                    <td>{{ $category->name }}</td>
                                                                    <td>{{ $category->deleted_at->format('d-m-Y') }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="4">Không có danh mục nào đã xóa mềm.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                    <button type="submit" class="btn btn-primary">Khôi phục các danh mục đã
                                                        chọn</button>
                                                </form>
                                            </thead>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                </div>
                                <!--end accordion-->
                            </div>
                        </div>
                        <div class="tab-pane" id="weekly" role="tabpanel">
                            <div class="profile-timeline">
                                <div class="accordion accordion-flush" id="weeklyExample">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck"></label>
                                                        </div>
                                                    </th>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Purchased</th>
                                                    <th scope="col">Revenue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck01">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck01"></label>
                                                        </div>
                                                    </th>
                                                    <td><a href="#" class="fw-semibold">#VZ2110</a></td>
                                                    <td>10 Oct, 14:47</td>
                                                    <td class="text-success"><i
                                                            class="ri-checkbox-circle-line fs-17 align-middle"></i>
                                                        Paid</td>
                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-3.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                Jordan Kennedy
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Mastering the grid</td>
                                                    <td>$9.98</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck02">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck02"></label>
                                                        </div>
                                                    </th>
                                                    <td><a href="#" class="fw-semibold">#VZ2109</a></td>
                                                    <td>17 Oct, 02:10</td>
                                                    <td class="text-success"><i
                                                            class="ri-checkbox-circle-line fs-17 align-middle"></i>
                                                        Paid</td>
                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-4.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                Jackson Graham
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Splashify</td>
                                                    <td>$270.60</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck03">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck03"></label>
                                                        </div>
                                                    </th>
                                                    <td><a href="#" class="fw-semibold">#VZ2108</a></td>
                                                    <td>26 Oct, 08:20</td>
                                                    <td class="text-primary"><i
                                                            class="ri-refresh-line fs-17 align-middle"></i>
                                                        Refunded
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-5.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                Lauren Trujillo
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Wireframing Kit for Figma</td>
                                                    <td>$145.42</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck04">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck04"></label>
                                                        </div>
                                                    </th>
                                                    <td><a href="#" class="fw-semibold">#VZ2107</a></td>
                                                    <td>02 Nov, 04:52</td>
                                                    <td class="text-danger"><i
                                                            class="ri-close-circle-line fs-17 align-middle"></i>
                                                        Cancel
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-6.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                Curtis Weaver
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Wireframing Kit for Figma</td>
                                                    <td>$170.68</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck05">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck05"></label>
                                                        </div>
                                                    </th>
                                                    <td><a href="#" class="fw-semibold">#VZ2106</a></td>
                                                    <td>10 Nov, 07:20</td>
                                                    <td class="text-success"><i
                                                            class="ri-checkbox-circle-line fs-17 align-middle"></i>
                                                        Paid</td>
                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-1.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                Jason schuller
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Splashify</td>
                                                    <td>$350.87</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                </div>
                                <!--end accordion-->
                            </div>
                        </div>
                        <div class="tab-pane" id="monthly" role="tabpanel">
                            <div class="profile-timeline">
                                <div class="accordion accordion-flush" id="monthlyExample">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck"></label>
                                                        </div>
                                                    </th>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Purchased</th>
                                                    <th scope="col">Revenue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck01">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck01"></label>
                                                        </div>
                                                    </th>
                                                    <td><a href="#" class="fw-semibold">#VZ2110</a></td>
                                                    <td>10 Oct, 14:47</td>
                                                    <td class="text-success"><i
                                                            class="ri-checkbox-circle-line fs-17 align-middle"></i>
                                                        Paid</td>
                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-3.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                Jordan Kennedy
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Mastering the grid</td>
                                                    <td>$9.98</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck02">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck02"></label>
                                                        </div>
                                                    </th>
                                                    <td><a href="#" class="fw-semibold">#VZ2109</a></td>
                                                    <td>17 Oct, 02:10</td>
                                                    <td class="text-success"><i
                                                            class="ri-checkbox-circle-line fs-17 align-middle"></i>
                                                        Paid</td>
                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-4.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                Jackson Graham
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Splashify</td>
                                                    <td>$270.60</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck03">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck03"></label>
                                                        </div>
                                                    </th>
                                                    <td><a href="#" class="fw-semibold">#VZ2108</a></td>
                                                    <td>26 Oct, 08:20</td>
                                                    <td class="text-primary"><i
                                                            class="ri-refresh-line fs-17 align-middle"></i>
                                                        Refunded
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-5.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                Lauren Trujillo
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Wireframing Kit for Figma</td>
                                                    <td>$145.42</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck04">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck04"></label>
                                                        </div>
                                                    </th>
                                                    <td><a href="#" class="fw-semibold">#VZ2107</a></td>
                                                    <td>02 Nov, 04:52</td>
                                                    <td class="text-danger"><i
                                                            class="ri-close-circle-line fs-17 align-middle"></i>
                                                        Cancel
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-6.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                Curtis Weaver
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Wireframing Kit for Figma</td>
                                                    <td>$170.68</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="responsivetableCheck05">
                                                            <label class="form-check-label"
                                                                for="responsivetableCheck05"></label>
                                                        </div>
                                                    </th>
                                                    <td><a href="#" class="fw-semibold">#VZ2106</a></td>
                                                    <td>10 Nov, 07:20</td>
                                                    <td class="text-success"><i
                                                            class="ri-checkbox-circle-line fs-17 align-middle"></i>
                                                        Paid</td>
                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-1.jpg" alt=""
                                                                    class="avatar-xs rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                Jason schuller
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Splashify</td>
                                                    <td>$350.87</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                </div>
                                <!--end accordion-->
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->

            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
    <!-- container-fluid -->
@endsection

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
@endsection

@section('script-libs')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
@endsection

@section('js')
    <script>
        document.getElementById('select-all').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('input[name="ids[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });
    </script>
@endsection
