<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\{StoreBrandRequest, UpdateBrandRequest};
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            DB::reconnect();
            return datatables()->of(Brand::query()->select(['id', 'name', 'slug', 'description'])
                ->get())
                ->addColumn('name', function ($row) {
                    // $urlEdit =  route('admin.brands.edit', $row);
                    $urlDestroy = route('admin.brands.destroy', $row);
                    return "
                    <strong class='text-primary'>$row->name</strong>
                    " . view('components.action', compact('row', 'urlDestroy')) . "
                    ";
                })
                ->addColumn('description', function ($row) {
                    return $row->description ?? '---';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '" />';
                })
                ->addIndexColumn()
                ->rawColumns(['name', 'description', 'checkbox'])
                ->make(true);
        }


        return view('backend.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $credentials = $request->validated();

        if (! $credentials['slug']) {
            $credentials['slug'] = Str::slug($credentials['name']);
        }

        Brand::create($credentials);

        return response()->json(['status' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $credentials = $request->validated();

        if (! $credentials['slug']) {
            $credentials['slug'] = Str::slug($credentials['name']);
        }

        Brand::where('id', $id)->update($credentials);

        return response()->json(['status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Brand::destroy($id);

        return response()->json(['status' => true]);
    }
}
