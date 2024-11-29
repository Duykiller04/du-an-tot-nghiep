<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // sleep(35);
        if (request()->ajax()) {
            $query = Customer::query()->latest('id');;
            // Lọc theo ngày tháng nếu có
            if (request()->has('startDate') && request()->has('endDate')) {
                $startDate = request()->get('startDate');
                $endDate = request()->get('endDate');

                // Kiểm tra định dạng ngày và lọc
                if ($startDate && $endDate) {
                    // Convert to datetime to include the full day
                    $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            return DataTables::of($query)
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y') : '';
                })
                ->addIndexColumn()
                ->addColumn('updated_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.customers.show', $row->id);
                    // $editUrl = route('admin.customers.edit', $row->id);
                    $deleteUrl = route('admin.customers.destroy', $row->id);

                    return '
            <a href="' . $viewUrl . '" class="btn btn-primary">Xem</a>
            <button class="btn btn-warning edit-btn" data-id="' . $row->id . '"  data-name="' . $row->name . '"   data-phone="' . $row->phone . '" data-address="' . $row->address . '" data-email="' . $row->email . '" data-age="' . $row->age . '" data-weight="' . $row->weight . '">Sửa</button>
            <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '">Xóa</button>
            </form>
        ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        try {
            $data = [
                'name' => $request->input('nameCreate'),
                'phone' => $request->input('phoneCreate'),
                'address' => $request->input('addressCreate'),
                'email' => $request->input('emailCreate'),
                'age' => $request->input('ageCreate'),
                'weight' => $request->input('weightCreate'),
            ];
            // dd($data);
            Customer::query()->create($data);
            return redirect()->route('admin.customers.index')->with('success', 'Thêm mới thành công');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('admin.customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id); //trả về 404
        return view('admin.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        try {
            $customer = Customer::findOrFail($id);

            $data = [
                'name' => $request->input('nameEdit'),
                'phone' => $request->input('phoneEdit'),
                'address' => $request->input('addressEdit'),
                'email' => $request->input('emailEdit'),
                'age' => $request->input('ageEdit'),
                'weight' => $request->input('weightEdit'),

            ];
            $customer->update($data);
            // dd( $customer);
            return back()->with('success', 'Sửa Thành công');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('success', 'Xóa khách hàng thành công.');
    }
}
