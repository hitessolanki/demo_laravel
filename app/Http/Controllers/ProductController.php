<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\TblUser;
use App\TblProduct;
use App\TblCategory;
use Session;
use Illuminate\Support\Facades\DB;
// use DB;     
use Crypt;

class ProductController extends Controller
{
    function showLoginForm(){
        return view('login');
    }
    function login(Request $req){
        $validator= $this->validate($req,[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $result = DB::table('tbl_users')
        ->where('email', $req->input('email'))
        ->get();
        $res = json_decode($result,true);
        // dd( crypt::encrypt($req->input('password')));
        if(sizeof($res)==0){
            $req->session()->flash("error","'Email Id does not exist. Please register yourself first.");
            return redirect('/login');
        }else{
            $encrypted_password = $result[0]->password;
            // dd($result[0]);
            $decrypted_password = $encrypted_password;
            if($decrypted_password==$req->input('password')){
                // $token= Str::random(60);
                // $q=TblUser::where('id',$res[0]['id']);
                // $q->update(['token' => hash('sha256', $token)]);
                
                echo "You are logged in Successfully";
                $req->session()->put('user',$result[0]->username);
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
    function showAddProductForm(Request $req){
        $q = TblCategory::where('user_id',$req->session()->get('id'))
        ->orderBy('id', 'desc')
        ->get();
        $res = json_decode($q,true);
        // dd($res);
        return view('addproduct', ['category'=>$res]);
    }
    function listuser(Request $req){
        $result = DB::table('tbl_users')
        ->get();
        // $crpt=new Crypt;
        $res = json_decode($result, true);
        // dd($res);
        if(sizeof($res)==0){
        }else{
            return view('list', ["res"=> $res]);
        }
    }

    function addCategory(Request $req){
        $validator= $this->validate($req,[
            'category_name' => 'required|regex:/^[a-z A-Z]+$/u',
        ]);
        $resto= new TblCategory;
        
            $resto->category_name=$req->input('category_name');
            $resto->user_id=$req->session()->get('id');
            $resto->save();
            $id=$req->session()->get('id');
            $result = tblCategory::where('user_id', $id)
            ->selectRaw('tbl_categories.*, tbl_users.username as customer_name')
            ->join('tbl_users','tbl_categories.user_id','=','tbl_users.id')->get();
            $res = json_decode($result,true);
            $req->session()->flash("register_status","Category has been saved successfully.");
            return view('categorylist',["res"=> $res]);
    }

    function addProduct(Request $req){
        $validator= $this->validate($req,[
            'product_name' => 'required|regex:/^[a-z A-Z]+$/u',
            'category_id'=> 'required'
        ]);
        $resto= new TblProduct;
        // dd($req->all());die;
            $resto->product_name=$req->input('product_name');
            $resto->category_id=$req->input('category_id');
            $resto->save();
            $id=$req->session()->get('id');
            $result = DB::table('tbl_products')
            ->join('tbl_categories', 'tbl_categories.id', '=', 'tbl_products.category_id')
            ->select('tbl_products.*','tbl_categories.category_name')
            ->get();
        
        // $crpt=new Crypt;
        $res = json_decode($result,true);
            $req->session()->flash("register_status","Product has been saved successfully.");
            return view('productdetails',["res"=> $res]);
    }
    function listCategory(Request $request){
        $id=$request->session()->get('id');
        $result = tblCategory::where('user_id', $id)
        ->selectRaw('tbl_categories.*, tbl_users.username as customer_name')
        ->join('tbl_users','tbl_categories.user_id','=','tbl_users.id')->get();
        // $crpt=new Crypt;
        $res = json_decode($result,true);
        // dd($res);
        return view('categorylist',["res"=> $res]);
    }
    function editCategory($id){
        $id=$id;
        $result = tblCategory::where('tbl_categories.id', $id)
        ->selectRaw('tbl_categories.*, tbl_users.username as customer_name')
        ->join('tbl_users','tbl_categories.user_id','=','tbl_users.id')->get();
        // $crpt=new Crypt;
        $res = json_decode($result,true);
        // dd($res);
        return view('editcategory', ["res"=> $res]);
    }
    function editProduct(Request $req, $id){
        $id=$id;
        $result = tblProduct::where('tbl_products.id', $id)
        ->selectRaw('tbl_products.*, tbl_categories.category_name')
        ->join('tbl_categories','tbl_categories.id','=','tbl_products.category_id')->get();
        // $crpt=new Crypt;
        $res = json_decode($result,true);
        $q = TblCategory::where('user_id',$req->session()->get('id'))
        ->orderBy('id', 'desc')
        ->get();
        $rescat = json_decode($q,true);
        // dd($res);
        return view('editproduct', ["res"=> $res,'category'=>$rescat]);
    }
    function deleteCategory(Request $req, $id){
        $q = TblCategory::find($id);
        $q->delete();
        // dd($q);
            $id=$req->session()->get('id');
            $result = tblCategory::where('user_id', $id)
            ->selectRaw('tbl_categories.*, tbl_users.username as customer_name')
            ->join('tbl_users','tbl_categories.user_id','=','tbl_user.id')->get();
            $res = json_decode($result,true);
            $req->session()->flash("register_status","Category has been deleted successfully.");
        
            // return view('categorylist',["res"=> $res]);
            return redirect()->route('category_list', ["res"=> $res]);
    }
    function deleteProduct(Request $req, $id){
        $q = TblProduct::find($id);
        $q->delete();
        
            $req->session()->flash("register_status","Product has been deleted successfully.");
        
            $result = DB::table('tbl_products')
            ->join('tbl_categories', 'tbl_categories.id', '=', 'tbl_products.category_id')
            ->select('tbl_products.*','tbl_categories.category_name')
            ->get();
        
        // $crpt=new Crypt;
        $res = json_decode($result,true);
            return redirect()->route('getProduct', ["res"=> $res]);
    }
    function getProductList(){
        
        $result = DB::table('tbl_products')
            ->join('tbl_categories', 'tbl_categories.id', '=', 'tbl_products.category_id')
            ->select('tbl_products.*','tbl_categories.category_name')
            ->get();
        
        // $crpt=new Crypt;
        $res = json_decode($result,true);
        // dd($res);
        return view('productdetails',["res"=> $res]);
    }
    function updateCategory(Request $req){
        // dd($req->get('category_name'));
        $reqobj=[
            'category_name'=>$req->get('category_name')
        ];
        $q=TblCategory::where('id', $req->get('id'));
        $q->update($reqobj);
        $id=$req->session()->get('id');
        $result = tblCategory::where('user_id', $id)
        ->selectRaw('tbl_categories.*, tbl_users.username as customer_name')
        ->join('tbl_users','tbl_categories.user_id','=','tbl_users.id')->get();
        $res = json_decode($result, true);
        $req->session()->flash("register_status","Category has been updated successfully.");
        return redirect()->route('category_list', ["res"=> $res]);
    }
    function updateProduct(Request $req){
        // dd($req->get('category_name'));
        $reqobj=[
            'product_name'=>$req->get('product_name'),
            'category_id'=>$req->get('category_id'),
        ];
        $q=TblProduct::where('id', $req->get('id'));
        $q->update($reqobj);
        
        $result = DB::table('tbl_products')
            ->join('tbl_categories', 'tbl_categories.id', '=', 'tbl_products.category_id')
            ->select('tbl_products.*','tbl_categories.category_name')
            ->get();
        
        // $crpt=new Crypt;
        $res = json_decode($result,true);
        // dd($res);
        return redirect()->route('getProduct', ["res"=> $res]);
    }
    function logout(){
        Session::flush();
        return redirect('login');
    }
}
