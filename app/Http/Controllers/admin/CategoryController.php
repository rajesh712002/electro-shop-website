<?php

namespace App\Http\Controllers\admin;

use product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    //CATEGORY ===============================================================================================================================================

    public function category(Request $request)
    {
        $category = Category::latest();
        if (!empty($request->get('keyword'))) {
            $category = $category->where('name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%');

            $category = $category->paginate(100);
            return view('admin.category.categories', ['category' => $category]);
        } else {
            $category = $category->paginate(5);
            return view('admin.category.categories', ['category' => $category]);
        }
    }

    public function createCategory()
    {
        return view('admin.category.create_category');
    }

    public function storeCategory(Request $request)
    {
        //Validation 
        $rules = [
            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|unique:categories|max:100',
            'status' => 'required|max:50',
            'image' => 'required|image',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // return redirect()->route('admin.create_cat')->withInput()->withErrors($validator);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $category->image = $imagename;

        $category->save();

        return response()->json(['success' => 'Catagory Inserted successfully']);
    }


    //UPDATE Category


    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.update_category', [
            'category' => $category
        ]);
    }


    public function updateCategory($id, Request $request)
    {
        $category = Category::findOrFail($id);

        File::delete(public_path('admin_assets/images/' . $category->image));
        //Validation 
        $rules = [
            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|max:100|unique:categories,slug,' . $category->id . ',id',
            'status' => 'required|max:50'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // return redirect()->route('admin.create_cat')->withInput()->withErrors($validator);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //$category = new Category(); // If We Declare one more time than it insert a NEW Record
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $category->image = $imagename;

        $category->save();

        return response()->json(['success' => 'Catagory Updated successfully']);
    }


    //DELETE Category
    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        File::delete(public_path('admin_assets/images/' . $category->image));

        $category->delete();
        //return response()->json(['message' => 'Item Deleted successfully']);
        return redirect()->route('admin.category')->with('success', 'Catagory Deleted Successfully');
    }





    //SUB-CATEGORY ========================================================================================================================================

    public function viewSubcategory(Request $request)
    {
        // dd($subcategory->toArray());
        if (!empty($request->get('keyword'))) {
            $subcategory = Subcategory::with('category')->latest();
            $subcategory = $subcategory->where('subcate_name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('subcate_id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhereHas('category', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('keyword') . '%');
                });

            $subcategory = $subcategory->paginate(100);
            return view('admin.category.subcategory', ['subcategory' => $subcategory]);
        } else {

            $subcategory = Subcategory::with('category')->paginate(5);
            return view('admin.category.subcategory', compact('subcategory'));
        }
    }

    public function createSubcategory()
    {
        // $cat = Category::all();
        // return view('admin.category.create_subcategory', ['cat' => $cat]); //['cat'=>$cat]);
        $options = Category::where('status', 1)->pluck('name', 'id');
        return view('admin.category.create_subcategory', compact('options'));
    }
    public function storeSubcategory(Request $request)
    {
        $rules = [
            'category' => 'required|max:50',
            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|unique:subcategories|max:100',
            'status' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            //return redirect()->route('admin.create_subcat')->withInput()->withErrors($validator);
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $subcategory = new Subcategory();
        $subcategory->subcate_id = $request->category;
        $subcategory->subcate_name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $subcategory->image = $imagename;

        $subcategory->save();
        return response()->json(['success' => 'SubCatagory Inserted successfully']);
    }


    //UPDATE 


    public function editSubcategory($id)
    {
        $options = Category::where('status', 1)->pluck('name', 'id');
        $subcategory = Subcategory::findOrFail($id);
        return view('admin.category.update-subcategory', compact('options', 'subcategory'));
    }

    public function updateSubcategory($id, Request $request)
    {
        $subcategory = Subcategory::findOrFail($id);
        File::delete(public_path('admin_assets/images/' . $subcategory->image));
        $rules = [
            'category' => 'required|max:50',
            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|max:100|unique:subcategories,slug,' . $subcategory->id . ',id',
            'status' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            //return redirect()->route('admin.create_subcat')->withInput()->withErrors($validator);
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $subcategory->subcate_id = $request->category;
        $subcategory->subcate_name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $subcategory->image = $imagename;
        $subcategory->save();
        return response()->json(['success' => 'SubCatagory Updated successfully']);
    }


    //Delete Sub Category

    public function destroySubcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);

        File::delete(public_path('admin_assets/images/' . $subcategory->image));

        $subcategory->delete();
        //return response()->json(['message' => 'Item Deleted successfully']);
        return redirect()->route('admin.subcategory')->with('success', 'SubCatagory Deleted Successfully');
    }

    //Get Category wise Sub Category

    public function getCategories()
    {
        $category = Category::get();
        return response()->json($category);
    }

    public function getSubcategories($id)
    {
        $subcategory = Subcategory::where('subcate_id', $id)->get();
        return response()->json($subcategory);
    }
}
