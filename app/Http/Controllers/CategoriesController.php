<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryConfiguration;
use App\Models\Service;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class CategoriesController extends Controller
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

    /**
     * Display a listing of the categories.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
        * Ajax call by datatable for listing of the categories.
        */
        if ($request->ajax()) {
            $data = Category::latest()->get();
            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($category){
                        return view('categories.datatable', compact('category'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $categories = Category::paginate(25);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create(Request $request)
    {

        $service_id = $request->get('service_type');
        return view('categories.create', compact('service_id'));
    }

    /**
     * Store a new category in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);
            if($request->hasFile('image_file')) {

                $category_image_path = $request->file('image_file')->store('category');
                $data['image_file'] =  $category_image_path;
            }
            $category = Category::create($data);
            if($data['service_id'] == '2'){
                $category_config['category_id'] = $category->id;
                $category_config['minimum_charge'] = $data['minimum_charge'];
                $category_config['km_charge'] = $data['km_charge'];
                $category_config['cancellation_charge'] = $data['cancellation_charge'];
                $cat_config = CategoryConfiguration::create($category_config);
            }
            return redirect()->route('categories.category.view_categories',['type'=>$data['service_id']])
                ->with('success_message', trans('categories.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('categories.unexpected_error')]);
        }
    }

    /**
     * Display the specified category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $category = Category::where('id',$id)->with('categoryConfiguration')->first();

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        $service_id = $request->get('service_type');
        $category = Category::findOrFail($id);
        $category_config = null;
        if($category->service_id == '2') {
            $category_config =  CategoryConfiguration::where('category_id', $category->id)->first();
        }
        return view('categories.edit', compact('category','service_id','category_config'));
    }

    /**
     * Update the specified category in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {

            $data = $this->getData($request);
            $category = Category::findOrFail($id);
            if($request->hasFile('image_file')) {

                $category_image_path = $request->file('image_file')->store('category');
                $data['image_file'] =  $category_image_path;
            }  else {
                $data['image_file'] = $category->image_file;
            }
            $category->update($data);
            if($data['service_id'] == '2'){
                $category_config['category_id'] = $category->id;
                $category_config['minimum_charge'] = $data['minimum_charge'];
                $category_config['km_charge'] = $data['km_charge'];
                $category_config['cancellation_charge'] = $data['cancellation_charge'];
                $cat_config_model = CategoryConfiguration::where('category_id', $category->id)->first();
                if($cat_config_model) {
                     $cat_config_model->update($category_config);
                } else {
                     $cat_config = CategoryConfiguration::create($category_config);
                }

            } else {
                CategoryConfiguration::where('category_id', $category->id)->delete();
            }
            return redirect()->route('categories.category.view_categories',['type'=>$data['service_id']])
                ->with('success_message', trans('categories.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('categories.unexpected_error')]);
        }
    }

    /**
     * Remove the specified category from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $service_id = $category->service_id;
            $category->delete();
            $delete = CategoryConfiguration::where('category_id', $category->id)->delete();
            return redirect()->route('categories.category.view_categories',['type'=>$service_id])
                ->with('success_message', trans('categories.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('categories.unexpected_error')]);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        if($request->service_id == '2') {
            $rules = [
                'service_id' => 'required',
                'category' => 'string|min:1|nullable',
                'image_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'is_active' => 'boolean|nullable',
                'minimum_charge' => 'required',
                'km_charge' => 'required',
                'cancellation_charge' => 'required',
            ];
        } else {
            $rules = [
                'service_id' => 'required',
                'category' => 'string|min:1|nullable',
                'image_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'is_active' => 'boolean|nullable',
            ];
        }
        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

    public function view_category(Request $request,$id){
        /**
        * Ajax call by datatable for listing of the categories.
        */
        if ($request->ajax()) {
            $data = Category::where('service_id',$id)->get();
            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($category){
                        return view('categories.datatable', compact('category'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $categories = Category::paginate(25);
        $service_id = $id;
        return view('categories.view', compact('categories','service_id'));
    }

}
