<?php

namespace App\Http\Controllers;

use App\Models\PetAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PetStoreRequest;
use App\Http\Requests\PetStoreResquest;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\PetsAPI;

class PetsAPIsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['pets' => PetsAPI::all()]);
    }

    /**
     * Store a newly created pet in storage.
     *
     * @param  \App\Http\Requests\PetStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PetStoreResquest $request)
    {
        try {
            $imageName = null;

            if ($request->hasFile('image')) {
                $imageName = Str::random(32) . '.' . $request->image->getClientOriginalExtension();
                Storage::disk('public')->put($imageName, file_get_contents($request->image));
            }

            $pet = PetsAPI::create([
                'name' => $request->name,
                'age' => $request->age,
                'sex' => $request->sex,
                'vaccine' => $request->vaccine,
                'images' => $imageName, // This can be null if no image is uploaded
                'content' => $request->content,
            ]);

            return response()->json([
                'message' => "Pet successfully created.",
                'pet' => $pet,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went wrong!",
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pet = PetsAPI::find($id);

        if (!$pet) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        return response()->json(['pet' => $pet]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pet = PetsAPI::find($id);

        if (!$pet) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        $data = $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'sex' => 'required|string',
            'vaccine' => 'required|string',
            'content' => 'required|string',
        ]);

        $pet->update($data);

        return response()->json([
            'message' => 'Pet updated successfully',
            'pet' => $pet
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pet = PetsAPI::find($id);

        if (!$pet) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        $pet->delete();

        return response()->json(['message' => 'Pet deleted successfully'], 200);
    }
}