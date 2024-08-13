<?php

namespace Modules\CHEvents\Http\Controllers\Frontend;

use App\Contracts\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\CHEvents\Models\Event;

/**
 * Class $CLASS$
 * @package
 */
class IndexController extends Controller
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

        return view('chevents::frontend.index', ['events' => Event::orderByDesc('starting_at')->paginate(20)]);
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
        return view('chevents::frontend.show', ['event' => $event]);
    }

    public function attach(Event $event, Request $request)
    {
        $user = Auth::user();
        $event->users()->attach($user->id);
        return redirect()->back();
        //return response()->redirectToRoute('chevents.show', [$event]);
    }

    public function detach(Event $event, Request $request)
    {
        $user = Auth::user();
        $event->users()->detach($user->id);
        return redirect()->back();
        //return response()->redirectToRoute('chevents.show', [$event]);
    }

}
