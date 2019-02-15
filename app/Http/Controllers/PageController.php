<?php

namespace App\Http\Controllers;
use App\BillDetail;
use App\Cart;
use App\Slide;
use App\Product;
use App\ProductType;
use App\User;
use Auth;
use Session;
use App\Customer;
use App\Bill;
use Hash;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function getIndex(){
        $slide=Slide::all();
//        print_r($slide);
//        exit;
        $new_product=Product::where('new',1)->paginate(4);
        $sanpham_khuyenmai=Product::where('promotion_price','<>',0)->paginate(4);
//                print_r($sanpham_khuyenmai);
//        exit;
        return view('page.trangchu',compact('slide','new_product','sanpham_khuyenmai'));
    }
    public function getLoaiSp($type){
        $sp_theoloai=Product::where('id_type',$type)->get();
        $sanpham_khac=Product::where('id_type','<>',$type)->paginate(3);
        $loai=ProductType::all();
        $loai_sp=ProductType::where('id',$type)->first();
        return view('page.loai_sanpham',compact('sp_theoloai','sanpham_khac','loai','loai_sp'));
    }
    public function getChiTietSp(Request $req){
        $sanpham=Product::where('id',$req->id)->first();
        $sp_tuongtu=Product::where('id_type',$sanpham->id_type)->paginate(3);
        return view('page.chitiet_sanpham',compact('sanpham','sp_tuongtu'));
    }
    public function getLienHe(){
        return view('page.lienhe');
    }
    public function getGioiThieu(){
        return view('page.gioithieu');
    }
    public function getAddToCart(Request $req, $id){
        $product=Product::find($id);
        $oldcart=Session('cart')?\Session::get('cart'):null;
        $cart=new Cart($oldcart);
        $cart->add($product,$id);
        $req->session()->put('cart',$cart);
        return redirect()->back();
        return view('page.gioithieu');
    }
    public function getDelItemCart($id){
        $oldcart=Session('cart')?\Session::get('cart'):null;
        $cart=new Cart($oldcart);
        $cart->removeItem($id);
        if (count($cart->items)>0){
            Session::put('cart',$cart);
        }
        else{
            Session::forget('cart');
        }
        return redirect()->back();

    }
    public function getCheckOut(){
        if (Session::has('cart')){
            $oldCart=Session::get('cart');
            $cart=new Cart($oldCart);
            return view('page.dat_hang',['product_cart'=>$cart->items,'totalPrice'=>$cart->totalPrice,'totalQty'=>$cart->totalQty]);
        }
        else{
            return view('page.dat_hang');
        }

    }
    public function postCheckOut(Request $req)
    {
        $cart = Session::get('cart');

        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes;
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->notes;
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $bill_detail = new BillDetail;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = ($value['price'] / $value['qty']);
            $bill_detail->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao', 'Đặt hàng thành công');
    }
    public function getLogin(){
        return view('page.dangnhap');
    }
    public function getSignup(){
        return view('page.dangki');
    }
    public function postSignup(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|max:20',
                'fullname'=>'required',
                're_password'=>'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.unique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui lòng nhập mật khẩu ',
                're_password.same'=>'Mật khẩu không giống nhau ',
                'password.min'=>'Vui lòng nhập mật khẩu dài hơn 6 kí tự ',
                'password.max'=>'Vui lòng nhập mật khẩu ngắn hơn 20 kí tự '
            ]
        );
        $user=new User();
        $user->full_name=$req->fullname;
        $user->email=$req->email;
        $user->password=Hash::make($req->password);
        $user->phone=$req->phone;
        $user->address=$req->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Đăng kí thành công');
    }
    public function postLogin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:20'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'password.required'=>'Vui lòng nhập mật khẩu ',
                'password.min'=>'Vui lòng nhập mật khẩu dài hơn 6 kí tự ',
                'password.max'=>'Vui lòng nhập mật khẩu ngắn hơn 20 kí tự '
            ]
        );
        $credentials =array('email'=>$req->email,'password'=>$req->password);
        if (Auth::attempt($credentials)){
            return redirect()->back()->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
        }
        else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập thất bại']);
        }
    }
    public function getLogout(){
        Auth::logout();
        return redirect()->route('trang-chu');
    }
    public function getsearch(Request $req){
        $product=Product::where('name','like',"%".$req->key.'%')
                          ->orWhere('unit_price',$req->key)
                          ->get();
        return view('page.search',compact('product'));
    }

}
