<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Type;
use DB;
use Image;
class CategoryController extends Controller
{
    public function index()
    {
        $types=Type::all();
        $items=Category::latest()->paginate(20);
        $cats=Category::whereNull('parent_id')->select('name','id')->pluck('name','id')->toArray();
        return view('backend.categories.index', compact('items','types','cats'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('category.create'))
        {
            abort(403, 'unauthorized');
        }
        $data=$request->validate([
             'name'=> 'required',
          	 'url'=> 'required|unique:categories,url',
             'parent_id'=> '',
        ]);
        
        if($request->hasFile('image')) {
            $image = Image::make($request->file('image'));
  
            /**
             * Main Image Upload on Folder Code
             */
            $imageName = $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('categories/');
            $image->resize(90,90);
            $image->save($destinationPath.$imageName);
            $data['image']=$imageName;
        }

        Category::create($data);

        return response()->json(['status'=>true ,'msg'=>'Category Is  Created !!','url'=>route('admin.categories.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!auth()->user()->can('category.edit'))
        {
            abort(403, 'unauthorized');
        }

        $item=Category::find($id);
        $types=Type::all();
        $cats=Category::whereNull('parent_id')->select('name','id')->pluck('name','id')->toArray();
        return view('backend.categories.edit', compact('item','types','cats'));
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
        if(!auth()->user()->can('category.edit'))
        {
            abort(403, 'unauthorized');
        }

        $category=Category::find($id);
        $data=$request->validate([
             'name'=> 'required',
          	 'url'=> 'required|unique:categories,url,'.$id,
             'parent_id'=> '',
        ]);

        if($request->hasFile('image')) {
            deleteImage('categories', $category->image);
            
            $image = Image::make($request->file('image'));
            /**
             * Main Image Upload on Folder Code
             */
            $imageName = $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('categories/');
            $image->resize(90,90);
            $image->save($destinationPath.$imageName);
            $data['image']=$imageName;
        }
       
        $category->update($data);

        return response()->json(['status'=>true ,'msg'=>'Category Is Updated !!','url'=>route('admin.categories.index')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->can('category.delete'))
        {
            abort(403, 'unauthorized');
        }

        $category=Category::find($id);
        deleteImage('categories', $category->image);
        $category->delete();
        return response()->json(['status'=>true ,'msg'=>'Category Is Deleted !!']);

    }
    
    public function popularCatgeory(){
        
        $status=(request('is_popular')==1)?1:null;
        DB::table('categories')->whereIn('id', request('cat_ids'))->update(['is_popular'=>$status]);
        return response()->json(['status'=>true ,'msg'=>'Category Status Updated !!']);
    }

}
