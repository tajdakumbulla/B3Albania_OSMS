<?php

namespace App\Http\Controllers\admin;

use App\Mail\UserUpdated;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use App\Mail\UserCreated;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    public function datatable()
    {
        $users = User::select(['id', 'full_name', 'email', 'phone', 'user_level', 'created_at']);
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '
                <a href="/admin/user/edit/'.$user->id.'"><i class="material-icons">edit</i></a>
                
                ';
            })
            ->make();
        //<a href="'.route('users.show', ['id' => $user->id]).'"><i class="material-icons">pageview</i></a>
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'full_name' => 'required',
            'phone' => 'required',
            'user_level' => 'numeric|min:1|max:5',
            'postal_code' => 'required|alpha_num',
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['lat'] = '41.327953';
        $data['lng'] = '19.819025';
        $data['image'] = '';
        $data['verified'] = User::UNVERIFIED;
        $data['verification_token'] = User::generate_verification_code();
        $user = User::create($data);
        Mail::to($user->email)->send(new UserCreated($user));
        return view('admin.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['data' => User::findOrFail($id)], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.update')->with(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
        ];

        $this->validate($request, $rules);

        if($request->has('email') && $user->email != $request->email){
            $user->verified = User::UNVERIFIED;
            $user->verification_token = User::generate_verification_code();
            $user->email = $request->email;
            Mail::to($user->email)->send(new UserUpdated($user));
        }

        if($request->has('full_name')) $user->full_name = $request->full_name;
        if($request->has('phone')) $user->phone = $request->phone;
        if($request->has('address')) $user->address = $request->address;
        if($request->has('city')) $user->city = $request->city;
        if($request->has('postal_code')) $user->postal_code = $request->postal_code;
        if($request->has('password')) $user->password = bcrypt($request->password);
        if($request->has('user_level')) $user->user_level = $request->user_level;

        if($request->hasFile('profile_image')){
            if(Storage::disk('profile')->exists($user->image)){
                Storage::disk('profile')->delete($user->image);
            }
            $user->image = $request->image->store('', 'profile');
        }

        $user->save();

        return view('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user -> delete();
        return response()->json(['data' => $user], 201);
    }
}
