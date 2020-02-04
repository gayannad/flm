<?php

namespace App\Http\Controllers;

use App\Friend;
use App\FriendRequest;
use App\Notifications\RequestSentNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;

class FriendController extends Controller
{

    protected $user;
    protected $friendRequest;
    protected $friend;

    public function __construct(User $user, FriendRequest $friendRequest, Friend $friend)
    {
        $this->middleware(['auth', 'verified', 'preventBackButton']);
        $this->user = $user;
        $this->friendRequest = $friendRequest;
        $this->friend = $friend;
    }

    /**
     * method for get all active user list
     */
    public function userList()
    {
        $logged_user = auth()->user()->id;
        $users = $this->user->where('email_verified_at', '!=', null)
            ->where('id', '!=', $logged_user)
            ->paginate(10);
        return view('friends.find_friends', compact('users'));
    }

    /**
     * method for invite friend
     */
    public function addFriend($friend_id)
    {
        $user = $this->user->find($friend_id);
        $logged_user = auth()->user()->id;

        $checkRequests = $this->friendRequest
            ->where('user_id', $logged_user)
            ->where('user_to', $friend_id)
            ->count();

        if ($checkRequests == 0) {
            $friendRequest = $this->friendRequest;
            $friendRequest->user_id = $logged_user;
            $friendRequest->user_to = $friend_id;
            $friendRequest->status = Config::get('constants.status.pending');
            $friendRequest->save();


            $email = $user->email;

            $url = route('my-requests');
            $greeting = "Hi";
            $details = [
                'greeting' => $greeting,
                'body1' => 'Please accept my friend request,',
                'actionText' => 'Confirm',
                'actionURL' => "$url",
                'email' => $email,
            ];
            Notification::send($user, new RequestSentNotification($details, $email));
            return response('200');
        } else {
            return response('400');
        }
    }


    /**
     * method for get sent friend requests
     */
    public function sentRequests()
    {
        $logged_user = auth()->user()->id;
        $sent_requests = $this->friendRequest->with('user')
            ->where('user_id', $logged_user)
            ->paginate(10);
        return view('friends.sent_requests', compact('sent_requests'));
    }

    /**
     * method for get received friend requests
     */
    public function myRequests()
    {
        $logged_user = auth()->user()->id;
        $my_requests = $this->friendRequest->with('userFrom')
            ->where('user_to', $logged_user)
            ->paginate(10);
        return view('friends.my_requests', compact('my_requests'));
    }

    /**
     * method for get  friend list
     */
    public function friendList()
    {
        $logged_user = auth()->user()->id;
        $friends = $this->friend->with('friendUser')
            ->where('friend_id','!=',$logged_user)
            ->paginate(10);
        return view('friends.friend_list', compact('friends'));
    }

    /**
     * method for search friends by first name
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchFriends(Request $request)
    {
        $search = $request->get('search');
        $logged_user = auth()->user()->id;

        $friends = Friend::whereHas('friendUser', function ($query) use ($search) {
            $query->where('first_name', 'like', '%' . $search . '%');
        })
            ->with(['friendUser' => function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
            }]);
        $friends = $friends->where('friend_id','!=',$logged_user)->paginate(10);
        return view('friends.friend_list', compact('friends'));
    }

    /**
     * method for  approve friend request
     */
    public function approveRequest($request_id)
    {
        $logged_user = auth()->user()->id;
        $request = $this->friendRequest->find($request_id);
        $request->status = Config::get('constants.status.approved');
        $request->updated_at = date('Y-m-d H:i:s');
        $approve = $request->save();

        if ($approve) {

            $friend_one = new Friend();
            $friend_one->user_id = $logged_user;
            $friend_one->friend_id = $request['user_id'];
            $friend_one->save();

            $friend_two = new Friend();
            $friend_two->user_id = $request['user_id'];
            $friend_two->friend_id = $logged_user;
            $friend_two->save();

            return response('200');
        } else {
            return response('400');
        }
    }

    /**
     *method for remove friend
     */
    public function removeFriend($friend_id)
    {
        $friend= $this->friend->find($friend_id);
        $friend->delete();
    }
}
