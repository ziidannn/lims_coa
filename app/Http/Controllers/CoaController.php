<?php

namespace App\Http\Controllers;

use App\Models\AmbientAir;
use App\Models\Location;
use App\Models\Coa;
use App\Models\CoaSubject;
use App\Models\Customer;
use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoaController extends Controller
{
    public function index(Request $request)
    {
        $data = Customer::all();
        $description = Subject::all();
        return view('coa.index', compact('data', 'description'));
    }

    public function list_customer(Request $request)
    {
        $data = Customer::all();
        $description = Subject::all();
        return view('list_customer.index', compact('data', 'description'));
    }

    public function list_sample(Request $request, $id)
    {
        // Ambil data institute berdasarkan ID yang dikirim
        $customer = Customer::findOrFail($id);

        // Ambil data yang berelasi dari tabel coa_sample_subjectss
        $coa_subject = CoaSubject::where('customer_id', $id)->get();

        return view('list_customer.list_sample', compact('customer', 'coa_subject'));
    }

    public function getDataSample($id)
    {
        $data = CoaSubject::where('customer_id', $id)
            ->with('Subject') // Pastikan relasi ke sample_subjects dimuat
            ->get();

        return response()->json(['data' => $data]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'customer' => ['required'],
                'address' => ['required'],
                'name' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'subject_id' => ['required', 'array']
            ]);

            // Buat coa baru
            $cust = Customer::create([
                'customer' => $request->customer,
                'address' => $request->address,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Simpan subject_id ke tabel pivot
            if ($request->has('subject_id')) {
                $cust->Subjects()->attach($request->subject_id);
            }

            return redirect()->route('coa.index')->with('msg', 'Data berhasil ditambahkan');
        }

        $data = Customer::all();
        $description = Subject::orderBy('name')->get();
        return view('coa.create', compact('data', 'description'));
    }

    //Edit coa
    public function edit(Request $request, $id)
    {
        $data = Customer::find($id);
        $description = Subject::orderBy('name')->get();
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'customer' => ['required'],
                'address' => ['required'],
                'name' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'subject_id' => ['required', 'array'], // Pastikan ini array
            ]);

            // Update coa
            $data->update([
                'customer' => $request->customer,
                'address' => $request->address,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Update subject_id ke tabel pivot
            if ($request->has('subject_id')) {
                $data->Subjects()->sync($request->subject_id);
            }

            return redirect()->route('coa.index')->with('msg', 'Data berhasil diubah');
        }

        return view('coa.edit', compact('data', 'description'));
    }

    //Data coa
    public function data(Request $request)
    {
        $data = Customer::with(['Subjects' => function ($query) {
                $query->select('subjects.id', 'subjects.name');
            }])
            ->select('*')
            ->orderBy("id")
            ->get();

        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_description'))) {
                    $instance->whereHas('Subjects', function ($q) use ($request) {
                        $q->where('subjects.id', $request->get('select_description'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $search = $request->get('search');
                    $instance->where(function ($w) use ($search) {
                        $w->orWhere('no_sample', 'LIKE', "%$search%")
                            ->orWhere('date', 'LIKE', "%$search%")
                            ->orWhereHas('Subjects', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            });
                    });
                }
            })
            ->make(true);
    }
}
