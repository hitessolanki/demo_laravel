<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Restaurants;
use Session;
use DB;     
use Crypt;

class RestoController extends Controller
{
    //
    function registerUser(Request $request){
        $validator= $this->validate($request,[
            'name' => 'required|regex:/^[a-z A-Z]+$/u',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'mobile_number' => 'numeric|required'
        ]);
        // $user->fill($request->all());
        // $user->password = $request->password;
        // $user->save();
        // $result = DB::table('tbl_user')
        // ->where('email',$req->input('email'))
        // ->toSql();;
        
        $result = User::where('email', $request->input('email'))
        ->select('*')->get();

        // ->selectRaw('id,name,MAX(),MIN()email')
        // ->orderBy()
        // ->limit()
        // ->groupBy()
        // ->first();
        
        // dd($users);
        $user = new User();
        // empty() !empty()

        // $result = DB::table('users')
        // ->where('email',$request->input('email'))
        // ->get();
        // $crpt=new Crypt;
        $res = json_decode($result,true);
        if(sizeof($res)==0){
            // dd('test');
            // $user->name=$req->input('name');
            // $user->email=$req->input('email');
            // $user->password=Crypt::encrypt($req->input('password'));
            // $user->mobile_number=$req->input('mobile');
            $user->fill($request->all());
            $user->password = Crypt::encrypt($request->input('password'));;
            $user->insertdate=strtotime('now');
            // $user->save();
            $user->save();
            $request->session()->flash("register_status","User has been registered successfully.");
            return redirect('/register');
        }else{
            $request->session()->flash("register_status","This Email already exists.");
            return redirect('/register');
        }
        
    }
    function showLoginForm(){
        return view('login');
    }
    function showRegisterForm(){
        return view('register');
    }
    function login(Request $req){
        $validator= $this->validate($req,[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $result = DB::table('users')
        ->where('email', $req->input('email'))
        ->get();
        $res = json_decode($result,true);
        // dd($res[0]['id']);
        if(sizeof($res)==0){
            $req->session()->flash("error","'Email Id does not exist. Please register yourself first.");
            return redirect('/login');
        }else{
            $encrypted_password = $result[0]->password;
            $decrypted_password = crypt::decrypt($encrypted_password);
            // dd($decrypted_password);
            if($decrypted_password==$req->input('password')){
                $token= Str::random(60);
                $q=User::where('id',$res[0]['id']);
                $q->update(['token' => hash('sha256', $token)]);
                
                echo "You are logged in Successfully";
                $req->session()->put('user',$result[0]->name);
                $req->session()->put('id',$result[0]->id);
                return redirect('/');
                }
                else{
                $req->session()->flash('error','Password Incorrect!!!');
                echo "Email Id Does not Exist.";
                return redirect('login');
                }
        }
    }
    function showAddForm(){
        return view('add');
    }
    function listuser(Request $req){
        $result = DB::table('users')
        ->get();
        // $crpt=new Crypt;
        $res = json_decode($result,true);
        // dd($res);
        if(sizeof($res)==0){
        }else{
            
            return view('list',["res"=> $res]);
        }
    }

    function add(Request $req){
        $validator= $this->validate($req,[
            'name' => 'required|regex:/^[a-z A-Z]+$/u',
            'email' => 'required|email',
            'address' => 'required'
        ]);
        $resto= new Restaurants;
        // $result = DB::table('tbl_user')
        // ->where('email',$req->input('email'))
        // ->toSql();;
        $result = DB::table('restaurants')
        ->where('email',$req->input('email'))
        ->get();
        // $crpt=new Crypt;
        $res = json_decode($result,true);
        // dd($res);
        if(sizeof($res)==0){
            // dd('test');
            $resto->name=$req->input('name');
            $resto->email=$req->input('email');
            $resto->address=$req->input('address');
            $resto->contact_no='1234567890';
            $resto->user_id=$req->session()->get('id');
            $resto->save();
            $req->session()->flash("register_status","Restaurants has been saved successfully.");
            return redirect('/add');
        }else{
            $req->session()->flash("error","This Email already exists.");
            return redirect('/add');
        }
    }
    function listResto(Request $request){
        $id=$request->session()->get('id');
        $result = Restaurants::where('user_id', $id)
        ->selectRaw('restaurants.*, users.name as customer_name')
        ->join('users','restaurants.user_id','=','users.id')->get();
        // $crpt=new Crypt;
        $res = json_decode($result,true);
        // dd($res);
        return view('restolist',["res"=> $res]);
    }

    function logout(){
        Session::flush();
        return redirect('login');
    }
}
