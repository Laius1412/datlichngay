<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FieldsController extends Controller
{
    public function index()
    {
        $fields = DB::table('fields')
            ->leftJoin('sub_fields', 'fields.id', '=', 'sub_fields.field_id')
            ->select(
                'fields.id',
                'fields.name',
                'fields.location',
                'fields.ward',
                'fields.district',
                'fields.city',
                DB::raw('GROUP_CONCAT(DISTINCT sub_fields.type SEPARATOR ", ") as field_types')
            )
            ->groupBy('fields.id')
            ->get();

        return view('fields.index', compact('fields'));
    }

    public function show($id)
    {
        $field = DB::table('fields')
            ->leftJoin('sub_fields', 'fields.id', '=', 'sub_fields.field_id')
            ->select(
                'fields.id',
                'fields.name',
                'fields.location',
                'fields.ward',
                'fields.district',
                'fields.city',
                DB::raw('GROUP_CONCAT(DISTINCT sub_fields.type SEPARATOR ", ") as field_types')
            )
            ->where('fields.id', $id)
            ->groupBy('fields.id')
            ->first();

        if (!$field) {
            abort(404);
        }

        return view('fields.show', compact('field'));
    }
}

