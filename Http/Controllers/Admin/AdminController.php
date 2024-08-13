<?php

namespace Modules\CHEvents\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Models\Pirep;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Modules\CHEvents\Models\Event;
use Modules\CHEvents\Models\EventMatrix;

/**
 * Admin controller
 */
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('chevents::admin.index', ['events' => Event::paginate(20)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        return view('chevents::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $sd = Carbon::parse($data['starting_at']);
        $ed = Carbon::parse($data['ending_at']);

        if ($sd->isAfter($ed)) {
            Flash::error("Starting Date/Time is after Ending Date/Time.");
            return back();
        }
        $event = Event::create($data);
        return response()->redirectToRoute('admin.chevents.show', [$event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function edit(Event $event, Request $request)
    {
        return view('chevents::admin.edit', ['event' => $event]);
    }

    /**
     * Show the specified resource.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function show(Event $event, Request $request)
    {
        $pireps = $event->matrix()->whereNotNull('pirep_id')->get()->map(function($m) { return $m->pirep; });
        return view('chevents::admin.show', ['event' => $event, 'pireps' => $pireps]);
    }
    public function show_pireps(Event $event, Request $request) {
        $pireps = $event->matrix()->whereNotNull('pirep_id')->get()->map(function($m) { return $m->pirep; });
        return view('chevents::admin.show_pireps', ['event' => $event, 'pireps' => $pireps]);
    }

    public function attach_pirep(Event $event, Request $request) {
        $pirep = Pirep::findOrFail($request->input('pirep_id'));
        $event->matrix()->create([
            'pirep_id' => $pirep->id,
            'user_id' => $pirep->user_id
        ]);
        return response()->redirectToRoute('admin.chevents.pireps.index', $event);
    }

    public function detach_pirep(Event $event, Request $request) {
        $em = EventMatrix::where(['event_id' => $event->id, 'pirep_id' => $request->input('pirep_id')])->first();

        if ($em->flight_id == null) {
            $em->delete();
        } else {
            $em->pirep_id = null;
            $em->save();
        }
        return response()->redirectToRoute('admin.chevents.pireps.index', $event);
    }

    public function show_users(Event $event, Request $request) {
        $event->load('users');
        return view('chevents::admin.show_users', ['event' => $event]);
    }

    public function attach_user(Event $event, Request $request) {
        // check if already attached
        $user_id = $request->input('user_id');
        if (!$event->users->contains($user_id)) {
            $event->users()->attach($request->input('user_id'));
            Flash::success("User Attached!");
        } else {
            Flash::info("User Already Attached!");
        }
        return response()->redirectToRoute('admin.chevents.users.index', $event);
    }

    public function detach_user(Event $event, Request $request) {
        $event->users()->detach($request->input('user_id'));
        return response()->redirectToRoute('admin.chevents.users.index', $event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function update(Event $event, Request $request)
    {
        $data = $request->all();

        $sd = Carbon::parse($data['starting_at']);
        $ed = Carbon::parse($data['ending_at']);

        if ($sd->isAfter($ed)) {
            Flash::error("Starting Date/Time is after Ending Date/Time.");
            return back();
        }
        $event->update($request->all());
        return response()->redirectToRoute('admin.chevents.show', [$event]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     */
    public function destroy(Event $event, Request $request)
    {
        $event->delete();
        Flash::success("Event Deleted Successfully");
        return response()->redirectToRoute('admin.chevents.index');
    }
}
