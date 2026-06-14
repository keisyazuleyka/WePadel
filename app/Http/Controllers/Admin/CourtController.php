<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\CourtImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourtController extends Controller
{
    public function index()
    {
        $courts = Court::with('images')->paginate(10);
        return view('admin.courts.index', compact('courts'));
    }

    public function create()
    {
        return view('admin.courts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'is_available' => 'nullable|boolean',
            'primary_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $court = Court::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'price_per_hour' => $request->input('price_per_hour'),
            'is_available' => $request->has('is_available') ? $request->boolean('is_available') : true,
        ]);

        // Upload primary image
        if ($request->hasFile('primary_image')) {
            $path = $request->file('primary_image')->store('courts', 'public');
            CourtImage::create([
                'court_id' => $court->id,
                'image_path' => $path,
                'is_primary' => true,
            ]);
        }

        // Upload gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('courts', 'public');
                CourtImage::create([
                    'court_id' => $court->id,
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('admin.courts.index')->with('success', 'Court created successfully.');
    }

    public function edit(Court $court)
    {
        $court->load('images');
        return view('admin.courts.edit', compact('court'));
    }

    public function update(Request $request, Court $court)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'is_available' => 'nullable|boolean',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $court->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'price_per_hour' => $request->input('price_per_hour'),
            'is_available' => $request->has('is_available') ? $request->boolean('is_available') : false,
        ]);

        // If new primary image uploaded, deactivate old primary and save new one
        if ($request->hasFile('primary_image')) {
            // Mark existing primary as secondary
            CourtImage::where('court_id', $court->id)->where('is_primary', true)->update(['is_primary' => false]);

            $path = $request->file('primary_image')->store('courts', 'public');
            CourtImage::create([
                'court_id' => $court->id,
                'image_path' => $path,
                'is_primary' => true,
            ]);
        }

        // Upload gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('courts', 'public');
                CourtImage::create([
                    'court_id' => $court->id,
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('admin.courts.index')->with('success', 'Court updated successfully.');
    }

    public function destroy(Court $court)
    {
        // Delete related images from storage
        foreach ($court->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $court->delete();

        return redirect()->route('admin.courts.index')->with('success', 'Court deleted successfully.');
    }
}
