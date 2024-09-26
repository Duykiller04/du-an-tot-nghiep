@extends('admin.layouts.master')

@section('title')
    Danh sách khách hàng
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">thùng rác</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách khách hàng</a></li>
                            <li class="breadcrumb-item active">Danh sách</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0  me-2">Danh Sách :</h4>
                        <div class="flex-shrink-0 ">
                            <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#today" role="tab">
                                        Catalogues
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#weekly" role="tab">
                                        users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#monthly" role="tab">
                                        medicine
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content text-muted">
                            <div class="tab-pane active" id="today" role="tabpanel">
                                <div class="profile-timeline">
                                    <div class="accordion accordion-flush" id="todayExample">
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
                                                                class="ri-checkbox-circle-line fs-17 align-middle"></i> Paid
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/users/avatar-3.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                class="ri-checkbox-circle-line fs-17 align-middle"></i> Paid
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/users/avatar-4.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                class="ri-refresh-line fs-17 align-middle"></i> Refunded
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/users/avatar-5.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                class="ri-close-circle-line fs-17 align-middle"></i> Cancel
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/users/avatar-6.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                    <img src="assets/images/users/avatar-1.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                <div class="text-end mb-3">
                                                    <a href="#"><button type="button" class="btn btn-primary w-sm">Quay lại</button></a>
                                                    <button type="submit" class="btn btn-success w-sm">Save</button>
                                                </div>
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
                                                                    <img src="assets/images/users/avatar-3.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                    <img src="assets/images/users/avatar-4.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                class="ri-refresh-line fs-17 align-middle"></i> Refunded
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/users/avatar-5.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                class="ri-close-circle-line fs-17 align-middle"></i> Cancel
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/users/avatar-6.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                    <img src="assets/images/users/avatar-1.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                    <img src="assets/images/users/avatar-3.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                    <img src="assets/images/users/avatar-4.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                class="ri-refresh-line fs-17 align-middle"></i> Refunded
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/users/avatar-5.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                class="ri-close-circle-line fs-17 align-middle"></i> Cancel
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/users/avatar-6.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
                                                                    <img src="assets/images/users/avatar-1.jpg"
                                                                        alt="" class="avatar-xs rounded-circle" />
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
        <!--end row-->

    </div>




@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.6.0/jspdf.umd.min.js"></script>





    <!-- JS CỦA LOC VS XUẤT excel VÀ CÁC FILE -->
@endsection
