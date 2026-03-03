<?php

namespace App\Http\Controllers\utility;

use App\Http\Controllers\Controller;
use App\Models\utility\Announcement;
use App\Services\utility\AnnouncementService;
use App\Http\Requests\utility\AnnouncementRequest;
use Exception;


class AnnouncementController extends Controller
{
    protected $announcementService;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->announcementService = $announcementService;
    }

    public function index()
    {
        $this->authorize('accessannouncement', ['view']);
        $announcements = $this->announcementService->getAll()->reverse();
        return view('utility.announcement.index', compact('announcements'));
    }


    public function create()
    {
        $this->authorize('accessannouncement', ['create']);
        $announcements = Announcement::select('id', 'subject')->get();
        return view('utility.announcement.create', compact('announcements'));
    }


    public function store(AnnouncementRequest $request)
    {
        try {
            $announcement = $this->announcementService->create($request->validated());
            return redirect()->route('announcements.index')->with('success', 'Announcement Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accessannouncement', ['details']);
        $announcement = $this->announcementService->getItemById($id);
        return view('utility.announcement.show', compact('announcement'));
    }



    public function edit($id)
    {
        $this->authorize('accessannouncement', ['modify']);
        $announcement = Announcement::findOrFail($id);
        return view('utility.announcement.edit', compact('announcement'));
    }



    public function update(AnnouncementRequest $request, $id)
    {
        try {
            $announcement = $this->announcementService->update($id, $request->validated());
            return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accessannouncement', ['delete']);
            $this->announcementService->delete($id);
            return redirect()->route('announcements.index')->with('success', 'Announcement Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function expireAnnouncements()
    {
        Announcement::where('status', 'active')
            ->whereRaw('DATE_ADD(created_at, INTERVAL expire_after DAY) < NOW()')
            ->update(['status' => 'expired']);
    }


    public function deleteExpiredAnnouncements()
    {
        Announcement::where('status', 'expired')->delete();
    }

    public function toggleAnnouncementStatus($id)
    {
        $this->authorize('accessannouncement', ['modify']);
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found.'], 404);
        }

        $newStatus = $announcement->status === 'active' ? 'disabled' : 'active';
        $announcement->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Announcement status changed successfully');
    }
}
