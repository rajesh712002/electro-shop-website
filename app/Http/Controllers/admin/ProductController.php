<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function product(Request $request)
    {


        $product = Product::with('sub_category', 'brand', 'categorys')->latest();
        $orderID = Order::where('');
        // dd($product->toArray());
        if (!empty($request->get('keyword'))) {
            $product = $product->where('prod_name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('category_id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('sub_category_id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('brand_id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('description', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('price', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('qty', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhereHas('categorys', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('keyword') . '%');
                })
                ->orWhereHas('sub_category', function ($query) use ($request) {
                    $query->where('subcate_name', 'like', '%' . $request->get('keyword') . '%');
                })
                ->orWhereHas('brand', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('keyword') . '%');
                });


            $product = $product->paginate(20);
            return view('admin.product.product', compact('product'));
        } else {
            $product = Product::with('sub_category', 'brand', 'categorys')->paginate(7);
            return view('admin.product.product', compact('product'));
        }
    }

    public function createProduct()
    {
        $category = Category::where('status', 1)->pluck('name', 'id');
        $subcategory = Subcategory::where('status', 1)->pluck('subcate_name', 'id');
        $brand = Brand::where('status', 1)->pluck('name', 'id');
        return view('admin.product.create_product', compact('category', 'brand', 'subcategory'));
    }

    public function storeProduct(Request $request)
    {
        $rules = [
            'name' => 'required|alpha_num|max:50',
            'description' => 'required',
            'image' => 'required|image',
            'price' => 'required|numeric',
            'status' => 'required',
            'category' => 'required',
            'slug' => 'required|alpha_num',
            'qty' => 'required|numeric',
            'brand' => 'required|alpha_num'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = new Product();
        $product->prod_name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->sku = $request->sku;
        // $product->track_qty = $request->track_qty;
        $product->qty = $request->qty;
        $product->category_id  = $request->category;
        $product->sub_category_id  = $request->sub_category;
        $product->brand_id  = $request->brand;
        $product->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $product->image = $imagename;

        $product->save();

        return response()->json(['success' => 'Product Inserted successfully']);
    }

    //Update Product


    public function editProduct($id)
    {
        $category = Category::where('status', 1)->pluck('name', 'id');
        $subcategory = Subcategory::where('status', 1)->pluck('subcate_name', 'id');
        $brand = Brand::where('status', 1)->pluck('name', 'id');
        $product = Product::findOrFail($id);
        return view('admin.product.update_product', compact('category', 'brand', 'product', 'subcategory'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        // File::delete(public_path('admin_assets/images/' . $product->image));


        $rules = [
            'name' => 'required|alpha_num|max:50',
            'description' => 'required',
            'image' => 'required|image',
            'price' => 'required|numeric',
            'status' => 'required',
            'category' => 'required',
            'slug' => 'required|alpha_num|unique:products,slug,' . $product->id . ',id',
            'qty' => 'required|numeric',
            'brand' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product->prod_name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->sku = $request->sku;
        // $product->track_qty = $request->track_qty;
        $product->qty = $request->qty;
        $product->category_id  = $request->category;
        $product->sub_category_id  = $request->sub_category;
        $product->brand_id  = $request->brand;
        $product->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $product->image = $imagename;

        $product->save();

        return response()->json(['success' => 'Product Updated successfully']);
    }


    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);

        // File::delete(public_path('admin_assets/images/' . $product->image));

        $product->delete();
        //return response()->json(['message' => 'Item Deleted successfully']);
        return redirect()->route('admin.product')->with('success', 'Product Deleted Successfully');
    }



    //BRANDS =====================================================================================================================

    public function brand(Request $request)
    {
        $brand = Brand::latest();
        if (!empty($request->get('keyword'))) {
            $brand = $brand->where('name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%');

            $brand = $brand->paginate(100);
            return view('admin.product.brand', ['brand' => $brand]);
        } else {
            $brand = $brand->paginate(5);
            return view('admin.product.brand', ['brand' => $brand]);
        }
    }

    public function createBrand()
    {
        return view('admin.product.create_brand');
    }

    public function storeBrand(Request $request)
    {

        $rules = [

            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|unique:subcategories|max:100',
            'status' => 'required',
            'image' => 'required|image'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $brand->image = $imagename;

        $brand->save();

        return response()->json(['success' => 'Brand Inserted successfully']);
        // return redirect()->route('admin.brand')->with('success','Brand Inserted Successfully');


    }


    public function editBrand($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.product.update_brand', [
            'brand' => $brand
        ]);
    }

    public function updateBrand($id, Request $request)
    {

        $brand = Brand::findOrFail($id);
        File::delete(public_path('admin_assets/images/' . $brand->image));
        $rules = [

            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|max:100|unique:brands,slug,' . $brand->id . ',id',
            'image' => 'required|image',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = $request->status;
        // store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $brand->image = $imagename;

        $brand->save();

        return response()->json(['success' => 'Brand Updated successfully']);
        // return redirect()->route('admin.brand')->with('success','Brand Inserted Successfully');     
    }


    //DELETE Brand
    public function destroyBrand($id)
    {
        $brand = Brand::findOrFail($id);

        File::delete(public_path('admin_assets/images/' . $brand->image));

        $brand->delete();
        //return response()->json(['message' => 'Item Deleted successfully']);
        return redirect()->route('admin.brand')->with('success', 'Brand Deleted Successfully');
    }
}
