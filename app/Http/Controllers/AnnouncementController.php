<?php

namespace App\Http\Controllers;

use App\Models\Announcement; // Ensure you have the Announcement model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AnnouncementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);
    
        try {
            $announcement = Announcement::create([
                'title' => $request->title,
                'content' => $request->content,
                'status' => $request->status,
            ]);
            return response()->json(['message' => 'Announcement created successfully', 'data' => $announcement], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create announcement: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        return Cache::remember('announcements', 60, function () {
            return Announcement::all();
        });
    }

    public function show($id)
    {
        return Announcement::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update($request->only(['title', 'content', 'status']));
        return response()->json(['message' => 'Announcement updated successfully', 'data' => $announcement]);
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return response()->json(['message' => 'Announcement deleted successfully']);
    }
}
