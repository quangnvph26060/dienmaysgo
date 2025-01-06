<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\StoreAttributeRequest;
use App\Http\Requests\Attribute\UpdateAttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            DB::reconnect();
            return datatables()->of(Attribute::query()->with('attributeValues')->latest()->get())
                ->addColumn('name', function ($row) {
                    $urlEdit =  route('admin.attributes.edit', $row);
                    $urlDestroy = route('admin.attributes.destroy', $row);
                    return "
                    <a href=" . route('admin.attribute-values.index', ['slug' => $row->slug]) . "><strong>$row->name</strong></a>
                    " . view('components.action', compact('row', 'urlEdit', 'urlDestroy')) . "
                    ";
                })
                ->addColumn('teams', function ($row) {
                    return $row->attributeValues->pluck('value')->implode(', ');
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '" />';
                })
                ->addIndexColumn()
                ->rawColumns(['teams', 'name', 'checkbox'])
                ->make(true);
        }

        return view('backend.attribute.index');
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
    public function store(StoreAttributeRequest $request)
    {
        $credentials = $request->validated();

        if (! $credentials['slug']) {
            $credentials['slug'] = Str::slug($credentials['name']);
        }

        Attribute::create($credentials);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $credentials = $request->validated();

        if (! $credentials['slug']) {
            $credentials['slug'] = Str::slug($credentials['name']);
        }

        $attribute->update($credentials);

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        toastr()->success('Thao tác thành công.');

        return back();
    }
}
