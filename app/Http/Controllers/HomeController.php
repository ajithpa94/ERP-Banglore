<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Items;
use App\Models\Product;
use App\Models\Productcategory;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\QuantityType;
use App\Models\Sale;
use App\Models\Saleproduct;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getItem($id)
    {
        $prd =  Product::where('id', $id)->first();
        return json_encode(array('itemCode' => $prd->productitemcode, 'costPrice' => $prd->costprice));
    }

    public function getProducts($id)
    {
        $prd =  Product::where('create_by', $id)->get();
        $products = "<option value=>Please Select</option>";
        foreach ($prd as $row) {
            $products .= "<option value=" . $row->id . ">" . $row->productname . "</option>";
        }

        $productsCode = "<option value=>Please Select</option>";
        foreach ($prd as $row) {
            $productsCode .= "<option value=" . $row->productitemcode . ">" . $row->productitemcode . "</option>";
        }

        $lastId = Purchase::where('create_by', $id)->count();
        $branch = User::where('id', $id)->first();
        $yr = date('m') . date('y');
        $number = 'B' . $branch->branch . 'P_' . $yr . '_' . str_pad($lastId + 1, 5, 0, STR_PAD_LEFT);
        return json_encode(array('product' => $products, 'productsCode' => $productsCode, 'number' => $number));
    }
    public function getProduct($id)
    {
        $prd =  Product::where('create_by', $id)->get();
        $products = "<option value=>Please Select</option>";
        foreach ($prd as $row) {
            $products .= "<option value=" . $row->id . ">" . $row->productname . "</option>";
        }
        $lastId = Sale::where('create_by', $id)->count();
        $branch = User::where('id', $id)->first();
        $yr = date('m') . date('y');
        $number = 'B' . $branch->branch . 'S_' . $yr . '_' . str_pad($lastId + 1, 5, 0, STR_PAD_LEFT);
        return json_encode(array('product' => $products, 'number' => $number));
    }
    public function index(Request $request)
    {
        $data['productCount'] = Product::count();
        $data['PurchaseCount'] = Purchase::count();
        $data['SaleCount'] = Sale::count();
        $data['userId'] = $userId = $request->get('user') ? $request->get('user') : 0;

        if (Auth::user()->usertype == 1) {
            if ($userId != 0)
                $whr['stocks.create_by'] = $userId;
            else
                $whr = [];
        } else
            $whr = array('stocks.create_by' => Auth::user()->id);

        $data['users'] = User::where('usertype', 2)->get();
        $data['stock'] = Stock::select('stocks.*', 'products.productname', 'users.name')
            ->join('users', 'users.id', 'stocks.create_by')
            ->join('products', 'stocks.prodctid', '=', 'products.id')
            ->where($whr)
            ->orderBy('stocks.id')
            ->get();

        // $data['stock'] = Stock::select('stocks.*', 'products.productname', 'users.name')
        //     ->join('users', 'users.id', 'stocks.create_by')
        //     ->join('products', 'stocks.prodctid', '=', 'products.id')
        //     ->orderBy('stocks.id')
        //     ->get();

        return view('home', $data);
    }
    public function Addcategory()
    {
        return view('Addcategory');
    }
    public function addcategoryStore(Request $request)
    {
        $request->validate([
            'categoryname' => ['required', 'string', 'max:255', 'unique:productcategories'],
        ]);
        Productcategory::create([
            'categoryname' => $request->get('categoryname'),
        ]);
        return redirect('Addcategory')->with('message', 'Product Category Added Successfully');
    }
    public function Categorylist()
    {
        $data['category'] = Productcategory::where('status', 0)->orderBy('id')->get();
        return view('Categorylist', $data);
    }
    public function Categoryedit($id)
    {
        $data['category'] = Productcategory::where('id', $id)
            ->first();
        return view('Categoryedit', $data);
    }
    public function Categoryupdate(Request $request, $id)
    {
        $request->validate([
            'categoryname' => ['required', 'string', 'max:255'],
        ]);
        Productcategory::where('id', $id)->update([
            'categoryname' => $request->get('categoryname'),
        ]);
        return redirect('Categorylist')->with('message', 'Product Category Update Successfully');
    }
    public function destroy(Productcategory $categorys, $id)
    {
        Productcategory::where('id', $id)->update([
            'status' => 1
        ]);
        return redirect('Categorylist')
            ->with('message', 'Product Category has been deleted successfully');
    }
    //addproduct
    public function Addproduct()
    {
        $data['category'] = Productcategory::where('status', 0)->orderBy('id')->get();
        $data['users'] = User::where('usertype', 2)->get();
        return view('Addproduct', $data);
    }
    public function addproductStore(Request $request)
    {
        $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'productname' => ['required', 'string', 'max:255',],
            'quantity' => ['required', 'string'],
        ]);
        if (Auth::user()->usertype == 1)
            $create_by = $request->user;
        else
            $create_by = Auth::user()->id;
        if (Product::where(array('create_by' => $create_by, 'productname' => $request->productname))->count() > 0) {
            return redirect('Productlist')->with('error', 'Product already exist');
        }
        // productitemcode
        $db = new Product();
        $db->category = $request->category;
        $db->productname = $request->productname;
        $db->quantity = $request->quantity;
        // $db->productitemcode = $request->productitemcode;
        // $db->costprice = $request->costprice;
        // $db->salesprice = $request->salesprice;
        $db->create_by = $create_by;
        $db->save();
        $db->id;
        $stock = new Stock();
        $stock->stock_count = $request->quantity;
        $stock->prodctid = $db->id;
        $stock->create_by = $create_by;
        $stock->save();

        return redirect('Addproduct')->with('message', 'Product  Added Successfully');
    }
    public function Productlist(Request $request)
    {
        $data['userId'] = $userId = $request->get('user') ? $request->get('user') : 0;

        if (Auth::user()->usertype == 1) {
            if ($userId != 0)
                $whr['create_by'] = $userId;
            else
                $whr = [];
        } else
            $whr = array('products.create_by' => Auth::user()->id);

        $data['users'] = User::where('usertype', 2)->get();
        // $purchase = Purchase::select('purchases.*', 'users.name')->join('users', 'users.id', 'purchases.create_by')->orderBy('purchases.id')
        $data['product'] = Product::select('products.*', 'productcategories.categoryname', 'users.name')
            ->join('users', 'users.id', 'products.create_by')
            ->join('productcategories', 'products.category', '=', 'productcategories.id')
            ->where($whr)
            ->where('products.status', 0)
            ->orderBy('products.id')
            ->get();
        return view('Productlist', $data);
    }
    public function Productedit($id)
    {
        $data['category'] = Productcategory::where('status', 0)->orderBy('id')->get();
        $data['product'] = Product::where('id', $id)
            ->first();
        $data['users'] = User::where('usertype', 2)->get();
        return view('Productedit', $data);
    }
    public function Productupdate(Request $request, $id)
    {
        $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'productname' => ['required', 'string', 'max:255'],
        ]);
        if (Auth::user()->usertype == 1)
            $create_by = $request->user;
        else
            $create_by = Auth::user()->id;



        if (Product::where(array('create_by' => $create_by, 'productname' => $request->productname))->where('id', '!=', $id)->count() > 0) {
            return back()->with('error', 'Product already exist');
        }


        $db = Product::find($id);
        $db->category = $request->category;
        $db->productname = $request->productname;
        // $db->productitemcode = $request->productitemcode;
        // $db->costprice = $request->costprice;
        // $db->salesprice = $request->salesprice;
        $db->create_by = $create_by;
        $db->save();
        $db->id;
        return redirect('Productlist')->with('message', 'Product  Update Successfully');
    }
    public function destroys(Product $product, $id)
    {

        Product::where('id', $id)->update([
            'status' => 1
        ]);
        return redirect()->back()
            ->with('message', 'Product  has been deleted successfully');
    }


    public function stocklist(Request $request)
    {
        $data['userId'] = $userId = $request->get('user') ? $request->get('user') : 0;

        if (Auth::user()->usertype == 1) {
            if ($userId != 0)
                $whr['stocks.create_by'] = $userId;
            else
                $whr = [];
        } else
            $whr = array('stocks.create_by' => Auth::user()->id);

        $data['users'] = User::where('usertype', 2)->get();


        // $purchase = Purchase::select('purchases.*', 'users.name')->join('users', 'users.id', 'purchases.create_by')->orderBy('purchases.id')
        $data['stock'] = Stock::select('stocks.*', 'products.productname', 'users.name')
            ->join('users', 'users.id', 'stocks.create_by')
            ->join('products', 'stocks.prodctid', '=', 'products.id')
            ->where($whr)
            ->orderBy('stocks.id')
            ->get();

        return view('stocklist', $data);
    }
    public function stockedit($id)
    {

        $data['stock'] = Stock::select('stocks.*', 'products.productname')->join('products', 'products.id', 'prodctid')->where('stocks.id', $id)
            ->first();
        return view('stockedit', $data);
    }
    public function stockUpdate(Request $request, $id)
    {
        $request->validate([
            'productname' => ['required'],
            'quantity' => ['required'],
        ]);
        $stock = Stock::find($id);
        $stock->stock_count = $request->quantity;
        $stock->prodctid = $request->productname;
        $stock->save();

        return redirect('stocklist')->with('message', 'Stock Update Successfully');
    }
    public function destroye(Stock $stock, $id)
    {

        Stock::where('id', $id)->delete();
        return redirect()->back()
            ->with('message', 'Stock has been deleted successfully');
    }
    //purchase add or crud option
    //
    // addPurchase
    public function addPurchase()
    {

        $data['product'] = Product::orderBy('id')->get();
        if (Auth::user()->usertype != 1) {
            $data['product'] = Product::where('create_by', Auth::user()->id)->orderBy('id')->get();
            $lastId = Purchase::where('create_by', Auth::user()->id)->count();
            $branch = Auth::user()->branch;
            $yr = date('m') . date('y');
            $data['number'] = 'B' . $branch . 'P_' . $yr . '_' . str_pad($lastId + 1, 5, 0, STR_PAD_LEFT);
        } else {
            $lastId = Purchase::where('create_by', Auth::user()->id)->count();
            $branch = Auth::user()->branch;
            $yr = date('m') . date('y');
            $data['number'] = 'B' . $branch . 'P_' . $yr . '_' . str_pad($lastId + 1, 5, 0, STR_PAD_LEFT);
            $data['users'] = User::where('usertype', 2)->get();
        }

        return view('addPurchase', $data);
    }
    public function addPurchaseStore(Request $request)
    {

        // 
        $request->validate([
            'date' => ['required'],
            // 'invoicenumber' => ['required'],
            'number' => ['required'],
            'suppliername' => ['required', 'string'],
        ]);

        if (Auth::user()->usertype == 1)
            $create_by = $request->user;
        else
            $create_by = Auth::user()->id;

        $db = new Purchase();
        $db->date = $request->date;
        $db->invoicenumber = $request->invoicenumber;
        $db->number = $request->number;
        $db->suppliername = $request->suppliername;
        $db->create_by = $create_by;
        $db->save();
        $db->id;
        foreach ($request->productName as $key => $productName) {
            if ($productName != '') {
                $purchase = new PurchaseProduct();
                $purchase->productName = $productName;
                $purchase->purchaseid = $db->id;
                $purchase->quantities = $request->quantities[$key];
                // $purchase->costpriceid = $request->costpriceid;
                // $purchase->itemcodeid = $request->itemcodeid;
                $purchase->create_by = Auth::user()->id;
                $purchase->save();
                $model = Stock::where('prodctid', $productName)->first();
                $model->increment('stock_count', $request->quantities[$key]);
                $model->save();
            }
        }


        return redirect('purchaselist')->with('message', 'Purchase Added Successfully');
    }

    public function purchaselist(Request $request)
    {
        $userId = $userId = $request->get('user') ? $request->get('user') : 0;

        if (Auth::user()->usertype == 1) {
            if ($userId != 0)
                $whr['create_by'] = $userId;
            else
                $whr = [];
        } else
            $whr = array('purchases.create_by' => Auth::user()->id);
        $users = User::where('usertype', 2)->get();
        $purchase = Purchase::select('purchases.*', 'users.name')->join('users', 'users.id', 'purchases.create_by')->orderBy('purchases.id')
            ->where($whr)
            ->where('status', 0)
            ->get();
        $cnt = Purchase::join('users', 'users.id', 'purchases.create_by')
            ->where($whr)
            ->where('status', 0)
            ->count();

        if ($cnt % 10 == 0) {
            $count = $cnt / 10;
        } else {
            $a = $cnt % 10;
            $b = $cnt - $a;
            $count = ($b / 10) + 1;
        }
        $data = array();
        foreach ($purchase as $row) {
            $row['product'] = PurchaseProduct::join('products', 'products.id', 'purchase_products.productName')->where('purchaseid', $row->id)
                ->get();
            array_push($data, $row);
        }
        return view('purchaselist', compact('data', 'userId', 'users', 'count'));
    }
    public function Purchaseedit($id)
    {
        $data['purchase'] = $pr = Purchase::where('id', $id)
            ->first();
        $data['product'] = Product::where('create_by', $pr->create_by)->orderBy('id')->get();
        $data['purchaseproduct'] = PurchaseProduct::where('purchaseid', $id)->get();


        if (Auth::user()->usertype == 1) {
            $data['users'] = User::where('usertype', 2)->get();
        }
        return view('Purchaseedit', $data);
    }
    // Purchaseedit
    public function purchaseUpdate(Request $request, $id)
    {
        $request->validate([
            'date' => ['required'],
            // 'invoicenumber' => ['required'],
            'number' => ['required'],
            'suppliername' => ['required', 'string'],
        ]);

        $db = Purchase::find($id);
        $db->date = $request->date;
        $db->invoicenumber = $request->invoicenumber;
        $db->number = $request->number;
        $db->suppliername = $request->suppliername;
        $db->save();

        $d =  PurchaseProduct::where('purchaseid', $id)->get();
        foreach ($d as $r) {
            $model = Stock::where('prodctid', $r->productName)->first();
            $model->decrement('stock_count', $r->quantities);
            $model->save();
        }
        PurchaseProduct::where('purchaseid', $id)->delete();

        foreach ($request->productName as $key => $productName) {
            if ($productName != '') {
                $purchase = new PurchaseProduct();
                $purchase->productName = $productName;
                $purchase->purchaseid = $id;
                $purchase->quantities = $request->quantities[$key];
                $purchase->create_by = Auth::user()->id;
                $purchase->save();
                $model = Stock::where('prodctid', $productName)->first();
                $model->increment('stock_count', $request->quantities[$key]);
                $model->save();
            }
        }
        return redirect('purchaselist')->with('message', 'Purchase Update Successfully');
    }
    public function destro(Purchase $purchase, $id)
    {
        Purchase::where('id', $id)->update([
            'status' => 1
        ]);

        $d =  PurchaseProduct::where('purchaseid', $id)->get();
        foreach ($d as $r) {
            $model = Stock::where('prodctid', $r->productName)->first();
            $model->decrement('stock_count', $r->quantities);
            $model->save();
        }

        return redirect()->back()
            ->with('message', 'Purchase has been deleted successfully');
    }
    //sale crud option
    public function addsale()
    {
        $data['product'] = Product::orderBy('id')->get();
        if (Auth::user()->usertype != 1) {
            $data['product'] = Product::where('create_by', Auth::user()->id)->orderBy('id')->get();
            $lastId = Sale::where('create_by', Auth::user()->id)->count();
            $branch = Auth::user()->branch;
            $yr = date('m') . date('y');
            $data['number'] = 'B' . $branch . 'S_' . $yr . '_' . str_pad($lastId + 1, 5, 0, STR_PAD_LEFT);
        } else {
            $lastId = Purchase::where('create_by', Auth::user()->id)->count();
            $branch = Auth::user()->branch;
            $yr = date('m') . date('y');
            $data['number'] = 'B' . $branch . 'P_' . $yr . '_' . str_pad($lastId + 1, 5, 0, STR_PAD_LEFT);
            $data['users'] = User::where('usertype', 2)->get();
        }
        return view('addsale', $data);
    }
    public function addsaleStore(Request $request)
    {
        $request->validate([
            'date' => ['required'],
            'number' => ['required', 'string'],
            'suppliername' => ['required', 'string'],
            'productName' => ['required'],
            'quantities' => ['required'],

        ]);
        if (Auth::user()->usertype == 1)
            $create_by = $request->user;
        else
            $create_by = Auth::user()->id;


        $db = new Sale();
        $db->date = $request->date;
        $db->number = $request->number;
        $db->suppliername = $request->suppliername;
        $db->create_by = $create_by;
        $db->save();
        $db->id;
        foreach ($request->productName as $key => $productName) {
            if ($productName != '') {
                $sale = new Saleproduct();
                $sale->productName = $productName;
                $sale->saleid = $db->id;
                $sale->quantities = $request->quantities[$key];
                $sale->create_by = Auth::user()->id;
                $sale->save();
                $model = Stock::where('prodctid', $productName)->first();
                $model->decrement('stock_count', $request->quantities[$key]);
                $model->save();
            }
        }


        return redirect('salelist')->with('message', 'Sale Added Successfully');
    }



    public function salelist(Request $request)
    {
        $userId = $userId = $request->get('user') ? $request->get('user') : 0;

        if (Auth::user()->usertype == 1) {
            if ($userId != 0)
                $whr['create_by'] = $userId;
            else
                $whr = [];
        } else
            $whr = array('sales.create_by' => Auth::user()->id);

        $users = User::where('usertype', 2)->get();



        // $purchase = Purchase::select('purchases.*', 'users.name')->join('users', 'users.id', 'purchases.create_by')->orderBy('purchases.id')
        $sale = Sale::select('sales.*', 'users.name')->join('users', 'users.id', 'sales.create_by')->orderBy('sales.id')
            ->where($whr)
            ->where('sales.status', 0)
            ->get();

        $cnt = Sale::join('users', 'users.id', 'sales.create_by')->orderBy('sales.id')
            ->where($whr)
            ->where('sales.status', 0)
            ->count();

        if ($cnt % 10 == 0) {
            $count = $cnt / 10;
        } else {
            $a = $cnt % 10;
            $b = $cnt - $a;
            $count = ($b / 10) + 1;
        }

        $data = array();
        foreach ($sale as $row) {
            $row['product'] = Saleproduct::join('products', 'products.id', 'saleproducts.productName')->where('saleid', $row->id)->get();
            array_push($data, $row);
        }

        return view('salelist', compact('data', 'userId', 'users', 'count'));
    }
    //sale edit
    public function saleedit($id)
    {
        $data['sale'] = $sa =  Sale::where('id', $id)
            ->first();
        $data['product'] = Product::where('create_by', $sa->create_by)->orderBy('id')->get();
        $data['saleproduct'] = Saleproduct::where('saleid', $id)->get();

        if (Auth::user()->usertype == 1) {
            $data['users'] = User::where('usertype', 2)->get();
        }
        return view('saleedit', $data);
    }
    // saleedit
    public function saleUpdate(Request $request, $id)
    {
        $request->validate([
            'date' => ['required'],
            'number' => ['required'],
            'suppliername' => ['required', 'string'],
        ]);


        $db = Sale::find($id);
        $db->date = $request->date;
        $db->number = $request->number;
        $db->suppliername = $request->suppliername;

        $db->save();

        $d =  Saleproduct::where('saleid', $id)->get();
        foreach ($d as $r) {
            $model = Stock::where('prodctid', $r->productName)->first();
            $model->increment('stock_count', $r->quantities);
            $model->save();
        }
        Saleproduct::where('saleid', $id)->delete();

        foreach ($request->productName as $key => $productName) {
            if ($productName != '') {
                $sale = new Saleproduct();
                $sale->productName = $productName;
                $sale->saleid = $db->id;
                $sale->quantities = $request->quantities[$key];
                $sale->create_by = Auth::user()->id;
                $sale->save();
                $model = Stock::where('prodctid', $productName)->first();
                $model->decrement('stock_count', $request->quantities[$key]);
                $model->save();
            }
        }
        return redirect('salelist')->with('message', 'Sale Update Successfully');
    }
    public function saledestroy(Sale $sale, $id)
    {

        Sale::where('id', $id)->update([
            'sales.status' => 1
        ]);
        $d =  Saleproduct::where('saleid', $id)->get();
        foreach ($d as $r) {
            $model = Stock::where('prodctid', $r->productName)->first();
            $model->increment('stock_count', $r->quantities);
            $model->save();
        }
        // Saleproduct::where('id', $id)->update([
        //     'status' => 1
        // ]);
        return redirect()->back()
            ->with('message', 'Sale has been deleted successfully');
    }

    public function stock_count($id)
    {
        return  Stock::where('prodctid', $id)->pluck('stock_count');
    }
    public function purchasereport(Request $request)
    {
        $userId = $userId = $request->get('user') ? $request->get('user') : 0;

        if (Auth::user()->usertype == 1) {
            if ($userId != 0)
                $whr['create_by'] = $userId;
            else
                $whr = [];
        } else
            $whr = array('purchases.create_by' => Auth::user()->id);

        $users = User::where('usertype', 2)->get();




        $purchase = Purchase::select('purchases.*', 'users.name')->join('users', 'users.id', 'purchases.create_by')->orderBy('purchases.id')
            ->where($whr)
            ->where('status', 0)
            ->get();

        $cnt = Purchase::join('users', 'users.id', 'purchases.create_by')
            ->where($whr)
            ->where('status', 0)
            ->count();

        if ($cnt % 10 == 0) {
            $count = $cnt / 10;
        } else {
            $a = $cnt % 10;
            $b = $cnt - $a;
            $count = ($b / 10) + 1;
        }

        $data = array();

        foreach ($purchase as $row) {
            $row['product'] = PurchaseProduct::join('products', 'products.id', 'purchase_products.productName')->where('purchaseid', $row->id)
                ->get();
            array_push($data, $row);
        }
        return view('purchasereport', compact('data', 'userId', 'users', 'count'));
    }
    public function salereport(Request $request)
    {
        $userId = $userId = $request->get('user') ? $request->get('user') : 0;

        if (Auth::user()->usertype == 1) {
            if ($userId != 0)
                $whr['create_by'] = $userId;
            else
                $whr = [];
        } else
            $whr = array('sales.create_by' => Auth::user()->id);

        $users = User::where('usertype', 2)->get();
        // $purchase = Purchase::select('purchases.*', 'users.name')->join('users', 'users.id', 'purchases.create_by')->orderBy('purchases.id')
        $sale = Sale::select('sales.*', 'users.name')->join('users', 'users.id', 'sales.create_by')->orderBy('sales.id')
            ->where($whr)
            ->where('status', 0)
            ->get();

        $cnt = Sale::join('users', 'users.id', 'sales.create_by')->orderBy('sales.id')
            ->where($whr)
            ->where('status', 0)
            ->count();

        if ($cnt % 10 == 0) {
            $count = $cnt / 10;
        } else {
            $a = $cnt % 10;
            $b = $cnt - $a;
            $count = ($b / 10) + 1;
        }

        $data = array();
        foreach ($sale as $row) {
            $row['product'] = Saleproduct::join('products', 'products.id', 'saleproducts.productName')->where('saleid', $row->id)->get();
            array_push($data, $row);
        }

        return view('salereport', compact('data', 'userId', 'users', 'count'));
    }
    public function stockreport(Request $request)
    {
        $data['userId'] = $userId = $request->get('user') ? $request->get('user') : 0;

        if (Auth::user()->usertype == 1) {
            if ($userId != 0)
                $whr['stocks.create_by'] = $userId;
            else
                $whr = [];
        } else
            $whr = array('stocks.create_by' => Auth::user()->id);

        $data['users'] = User::where('usertype', 2)->get();


        // $purchase = Purchase::select('purchases.*', 'users.name')->join('users', 'users.id', 'purchases.create_by')->orderBy('purchases.id')
        $data['stock'] = Stock::select('stocks.*', 'products.productname', 'users.name')
            ->join('users', 'users.id', 'stocks.create_by')
            ->join('products', 'stocks.prodctid', '=', 'products.id')
            ->where($whr)
            ->orderBy('stocks.id')
            ->get();

        return view('stockreport', $data);
    }

    //item add
    public function Additem()
    {
        $data['qtytype']=QuantityType::get();
        return view('Additem',$data);
    }
    public function itemStore(Request $request)
    {
        $db = new Items();
        $db->quantitytype = $request->quantitytype;
        $db->itemname = $request->itemname;
        $db->itemcode = $request->itemcode;
        $db->quantity = $request->quantity;
        $db->price = $request->price;
        $db->taxrate = $request->taxrate;
        $db->save();
        return back()->with('message', 'Product  Added Successfully');
    }
    public function Itemlist(Request $request)
    {
        $data['items'] = Items::select('items.*', 'quantity_types.quantityTypes')
        ->join('quantity_types', 'items.quantitytype', '=', 'quantity_types.id')
        ->orderBy('items.id')
        ->get();
        return view('Itemlist', $data);
    }

    //qty add
    public function Addquantitytype()
    {
       
        return view('Addquantitytype');
    }

    public function QuantitytypeStore(Request $request)
    {
        $db = new QuantityType();
        $db->quantityTypes = $request->quantityTypes;
        $db->save();
        return back()->with('message', 'Product  Added Successfully');
    }
    public function Quantitytypelist(Request $request)
    {
       $data['qtytype']=QuantityType::get();
        return view('Quantitytypelist', $data);
    }
}
