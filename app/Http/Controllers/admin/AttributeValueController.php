<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeValue\{
    UpdateAttributeValue,
    StoreAttributeValue
};
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attribute = Attribute::where("slug", request('slug'))->firstOrFail();
        if (request()->ajax()) {
            DB::reconnect();
            return datatables()->of(AttributeValue::query()->select(['id', 'value', 'slug', 'description'])
                ->where('attribute_id', $attribute->id)
                ->get())
                ->addColumn('value', function ($row) {
                    $urlDestroy = route('admin.attribute-values.destroy', $row);
                    return "
                    <strong class='text-primary'>$row->value</strong>
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
                ->rawColumns(['value', 'description', 'checkbox'])
                ->make(true);
        }


        return view('backend.attribute-value.index', compact('attribute'));
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
    public function store(StoreAttributeValue $request)
    {
        $credentials = $request->validated();

        if (! $credentials['slug']) {
            $credentials['slug'] = Str::slug($credentials['value']);
        }

        AttributeValue::create($credentials);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeValue $request, AttributeValue $attributeValue)
    {
        $credentials = $request->validated();

        if (! $credentials['slug']) {
            $credentials['slug'] = Str::slug($credentials['value']);
        }

        $attributeValue->update($credentials);

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeValue $attributeValue)
    {
        try {
            $attributeValue->delete();

            return response()->json([
                'status' => true
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
