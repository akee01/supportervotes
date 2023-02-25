<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\PremiumStars;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
     * Profile
     * ==========================
     */
    public function profile($id = null)
    {
        if (!$id) {
            if (!auth()->check()){
                return redirect()->route('login')->with(['alert-type' => 'warning', 'alert' => 'Login to view that page.']);
            }
            $id = auth()->id();
            $user = auth()->user();
        } else {
            $user = User::findorfail($id);
        }
        $stars = 0;
        $donations = 0;
        if ($user->role == 'creator') {
            $donations = Payment::where('creator_id', auth()->id())->sum('amount');
            $polls = $user->polls()->whereNull('archived_at')->get();
            if ($id && $id != auth()->id()) {
                $stars = auth()->check() ? auth()->user()->stars()->where(['creator_id' => $user->id])?->first()?->stars : 0;
            }
        } else {
            $polls = Poll::whereNull('archived_at')->whereIn('id', $user->votes()->distinct('poll_id')->pluck('id')->toArray())->get();
        }
        return view('profile', compact('user', 'polls', 'stars', 'donations'));
    }

    public function edit_profile()
    {
        return view('edit-profile');
    }

    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => 'string|required|max:64',
            'detail' => 'string|required|max:2000',
            'star_rate' => 'numeric|nullable'
        ]);
        $user = auth()->user();
        $user->name = $request->name;
        $user->detail = $request->detail;
        $user->star_rate = $request->star_rate;
        if ($user->save()) {
            return redirect(route('profile'))->with(['alert' => 'Profile updated.', 'alert-type' => 'success']);
        } else {
            return redirect()->back()->with(['alert' => 'Something went wrong.', 'alert-type' => 'danger']);
        }
    }

    /*
    * Polls
    * ==========================
    */

    public function create_poll()
    {
        return view('polls.create');
    }

    public function edit_poll($poll_id)
    {
        $poll = Poll::findorfail($poll_id);
        return view('polls.edit', compact('poll'));
    }

    public function update_poll(Request $request, $poll_id)
    {
        $request->validate([
            'option' => ['array', 'required'],
            'date' => ['string', 'nullable'],
            'time' => ['string', 'nullable'],
        ]);
        try {
            $poll = Poll::findorfail($poll_id);
            $poll->options()->whereNotIn('id',$request->finalised)->delete();
            $new_options = array_slice($request->option,count($request->finalised));
            if (!is_null($request->date) && !is_null($request->time)) {
                $closing = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);
                $poll->closing_at = $closing;
                $poll->save();
            }
            foreach ($new_options as $opt) {
                $pollOption = new PollOption();
                $pollOption->option = $opt;
                $poll->options()->save($pollOption);
            }
            return redirect()->back()->with(['alert' => 'Poll updated successfully.', 'alert-type' => 'success']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['alert' => 'Something went wrong.', 'alert-type' => 'danger']);
        }
    }

    public function archived_polls($id = null)
    {
        $id = auth()->id();
        $user = auth()->user();
        $stars = 0;
        $donations = 0;
        $donations = Payment::where('creator_id', auth()->id())->sum('amount');
        $polls = $user->polls()->whereNotNull('archived_at')->get();
        if ($id && $id != auth()->id()) {
            $stars = auth()->check() ? auth()->user()->stars()->where(['creator_id' => $user->id])?->first()?->stars : 0;
        }
        return view('profile', compact('user', 'polls', 'stars', 'donations'));
    }

    public function store_poll(Request $request)
    {
        $request->validate([
            'question' => 'string|required|max:191',
            'date' => 'string|nullable',
            'time' => 'string|nullable',
            'option' => 'array|required'
        ]);
        $closing = null;
        if (!is_null($request->date)) {
            $closing = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);
        }
        try {
            $poll = Poll::create([
                'user_id' => auth()->id(),
                'question' => $request->question,
                'closing_at' => $closing
            ]);
            foreach ($request->option as $opt) {
                $pollOption = new PollOption();
                $pollOption->option = $opt;
                $poll->options()->save($pollOption);
            }
            return redirect()->route('profile')->with(['alert' => 'Poll created successfully.', 'alert-type' => 'success']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['alert' => 'Something went wrong.', 'alert-type' => 'danger']);
        }
    }

    public function single_poll($id)
    {
        $poll = Poll::whereNull('archived_at')->findorfail($id);
        $vote_stars = $poll->votes->where('type', 'premium')->sum('stars');
        $stars = PremiumStars::where(['creator_id' => $poll->user_id, 'user_id' => auth()->id()])->first()?->stars ?? 0;
        return view('polls.detail', compact('poll', 'stars', 'vote_stars'));
    }

    public function destroy_poll($id)
    {
        $poll = Poll::findorfail($id);
        $poll->delete();
        return redirect()->back()->with(['alert' => 'Poll deleted successfully.', 'alert-type' => 'success']);
    }

    public function finalize_poll($id)
    {
        $poll = Poll::findorfail($id);
        if ($poll->archived_at){
            $poll->update(['archived_at' => null]);
        }else{
            $poll->update(['archived_at' => now()]);
        }
        return redirect()->route('profile')->with(['alert' => 'Poll updated successfully.', 'alert-type' => 'success']);
    }

    public function vote(Request $request)
    {
        $data = $request->validate([
            'poll_option_id' => 'required|integer|exists:poll_options,id',
            'type' => 'nullable|in:standard,premium',
            'stars' => 'nullable|integer',
            'description' => 'nullable|string'
        ]);
        $option = PollOption::findorfail($request->poll_option_id);
        if (PollVote::where(['user_id' => auth()->id(), 'poll_id' => $option->poll->id])->count() > 0) {
            return json_encode([
                'success' => false,
                'message' => 'Your vote is already registered.'
            ]);
        } else if (!is_null($option->poll->closing_at) && $option->poll->closing_at < now()) {
            return json_encode([
                'success' => false,
                'message' => 'Voting time has passed now.'
            ]);
        }
        if (isset($data['type']) && $data['type'] === 'premium') {
            $stars = auth()->user()?->stars()->where('creator_id', $option->poll->user_id)?->first();
            if (!$stars || $stars->stars < $data['stars']) {
                return json_encode([
                    'success' => false,
                    'message' => 'Not enough stars.'
                ]);
            }
            $stars->update([
                'stars' => $stars->stars - $data['stars']
            ]);
        }
        $data['user_id'] = auth()->id();
        $data['poll_id'] = $option->poll->id;
        $vote = PollVote::create($data);
        if (isset($data['type']) && $data['type'] == 'premium') {
            $option->votes += $data['stars'];
        } else {
            $option->votes += 1;
        }
        $option->save();
        return json_encode([
            'success' => true,
            'votes' => $option->poll->options
        ]);
    }

    public function balance()
    {
        $payments = Payment::where(['creator_id' => auth()->id()])->orderBy('created_at', 'desc')->get();
        return view('balance', compact('payments'));
    }

    public function withdraw()
    {
        Payment::where(['creator_id' => auth()->id(), 'payment_status' => 'settled'])->update([
            'payment_status' => 'requested'
        ]);
        return redirect()->back()->with(['alert' => 'Withdrawal requested.', 'alert-type' => 'success']);
    }
}
