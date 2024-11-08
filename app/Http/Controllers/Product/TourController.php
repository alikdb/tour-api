<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        if ($request->has('start_date')) {
            $tours = Tour::where('start_date', '>=', $request->start_date)->with('user')->get();
            return response()->json($tours, 200);
        }

        $tours = Tour::with('user')->get();

        return response()->json($tours, 200);

        //
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'price' => 'required|numeric',
        ]);

        $tour = Tour::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'price' => $request->price,
            'user_id' => auth()->user()->id
        ]);

        return response()->json($tour, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        $tour = Tour::find($id)->with('user')->first();

        // Check if tour exists

        if (!$tour) {
            return response()->json([
                'message' => 'Tur bulunamadı'
            ], 404);
        }

        return response()->json($tour, 200);
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
    public function update(Request $request, string $id)
    {

        $tour = Tour::find($id);

        // Check if tour exists

        if (!$tour) {
            return response()->json([
                'message' => 'Tur bulunamadı'
            ], 404);
        }

        $user = auth()->user();

        // Check if user is the owner of the tour
        // or user is superadmin

        if ($user->role != "superadmin" && $user->id != $tour->user_id) {
            return response()->json([
                'message' => 'Bu işlemi yapmaya yetkiniz yok'
            ], 403);
        }


        $request->validate([
            'name' => 'string',
            'description' => 'string',
            'location' => 'string',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'price' => 'numeric',
        ]);

        $tour->update($request->all());
        return response()->json($tour, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = auth()->user();

        $tour = Tour::find($id);

        // Check if tour exists

        if (!$tour) {
            return response()->json([
                'message' => 'Tur bulunamadı'
            ], 404);
        }
        // Check if user is superadmin
        if ($user->role != "superadmin") {
            return response()->json([
                'message' => 'Bu işlemi yapmaya yetkiniz yok'
            ], 403);
        }
        $tour->delete();

        return response()->json([
            'message' => 'Tur başarıyla silindi'
        ], 200);
    }
}
