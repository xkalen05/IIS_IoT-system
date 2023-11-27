<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Traits\CheckEmail;

class UserController extends Controller
{
    use CheckEmail;
    /**
     * Checks if user param $id is identical with email
     *
     * @return true If email and id is one user or email is not used yet
     * @return false If email is already in use by another user
     */
    function checkUserIDByEmail($email,$id):bool{
        $uid = DB::table('users')
            ->where('email','=',"$email")
            ->select('id')
            ->get();

        if($uid->isEmpty()){
            return true;
        }

        if($uid->first()->id === $id){
            return true;
        }
        return false;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $currentUser = Auth::id();
        $users = DB::table('users')->where('id', '!=', $currentUser)->paginate(1000);

        return view('admin.users.index')->with(['users' => $users]);
    }

    public function indexProfile(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();

        return view('profile.index')->with(['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'surname' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255|email|unique:users',
            'role' => 'required',
            'password' => 'required|min:8|max:255',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        if(!$this->CheckEmailFunc($request->input('email'))){
            return redirect()->back()->with('error','email is in wrong format')->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect(route('admin.users'))->with('success', 'User ' . $request->input('name') . ' ' .
            $request->input('surname') .' successfully created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editUserByAdmin(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'surname' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255|email',
            'role' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        if(!$this->CheckEmailFunc($request->input('email'))){
            return redirect()->back()->with('error','email is in wrong format')->withInput();
        }

        if(!$this->checkUserIDByEmail($request->input('email'),$request->input('user_id'))){
            return redirect(route('admin.users'))->with('error','Email is already used by another user');
        }

        DB::table('users')->where('id', '=', $request->input('user_id'))->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);

        return redirect(route('admin.users'))->with('success', 'Changes were successfully saved');

    }

    public function editUserByUser(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'surname' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255|email',
            'user_id' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        if(!$this->CheckEmailFunc($request->input('email'))){
            return redirect()->back()->with('error','email is in wrong format')->withInput();
        }

        if(!$this->checkUserIDByEmail($request->input('email'),$request->input('user_id'))){
            redirect()->back()->with('error','Email is already used by another user');
        }

        DB::table('users')->where('id', '=', $request->input('user_id'))->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
        ]);

        return redirect(route('profile.index'))->with('success', 'Changes were successfully saved');

    }

    public function editPasswordByAdmin(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|max:255',
            'user_id' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        DB::table('users')
            ->where('id', '=', $request->input('user_id'))
            ->update([
                'password' => Hash::make($request->input('password'))
            ]);

        return redirect(route('admin.users'))->with('success', 'Password for user ' . $request->input('name') . ' ' .
            $request->input('surname') .' was successfully changed.');
    }

    public function editPasswordByUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|max:255',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $newPassword = $request->input('password');

        Auth::user()->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect(route('profile.index'))->with('success', 'Password was successfully changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $systems = DB::table('systems')
                ->where('system_admin_id','=',"$id")
                ->select('id')
                ->get();

            foreach ($systems as $system){
                $sid = $system->id;
                DB::table('systems')
                    ->where('id','=',"$sid")
                    ->delete();
            }

            DB::table('users')
                ->where('id', '=', $id)
                ->delete();
        }catch (Exception $e){
            return redirect(route('admin.users'))->with('error', 'Could not remove user. Already does not exist or wrong ID');
        }
        return redirect(route('admin.users'))->with('success', 'User was successfully deleted');
    }


}
