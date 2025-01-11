<?php

namespace App\Http\Controllers;

use App\Jobs\ImportCustomersJob;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    public function customer(Request $request)
    {
        $query = Customer::query();

        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        $customers = $query->paginate(10);

        $total_customer_count = Customer::count();
        $total_male_customer_count = Customer::where('gender', 'M')->count();
        $total_female_customer_count = Customer::where('gender', 'F')->count();

        return response()->json([
            'customers' => $customers,
            'total_customer_count' => $total_customer_count,
            'total_male_customer_count' => $total_male_customer_count,
            'total_female_customer_count' => $total_female_customer_count
        ]);
    }

    public function import()
    {
        return view('import');
    }

    public function storeExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,csv',
        ]);
        $filePath = $request->file('import_file')->store('temp');
        ImportCustomersJob::dispatch($filePath);
        return redirect()->back()->with('status', 'File uploaded and queued for processing.');
    }
    public function Customerstore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_id' => 'required|',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:male,female,other,Male,Female,Others',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::create($request->all());

        return response()->json([
            'message' => 'Customer created successfully!',
            'customer' => $customer
        ], 201);
    }
}
