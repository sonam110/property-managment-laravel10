<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
use App\Models\Expense;
use App\Models\Property;
class ExpenseController extends Controller
{   
     public function index()
    {   
        $propertyTypes = Property::get()->pluck('property_name', 'id');
        return View('expense.index',compact('propertyTypes'));
    }
    public function expenseList(Request $request)
    {
        $query = Expense::with('property')->orderBy('id','DESC');
        if(!empty($request->property_id))
        {
            $query->where('property_id', $request->property_id);
        }
        if($request->type!='')
        {
            $query->where('type', $request->type);
        }
        return datatables($query)
            ->editColumn('property_id', function ($query)
            {

                return $query->property->property_name.'('.$query->property->property_code.')';
            })
           
            ->editColumn('type', function ($query)
            {
                if ($query->type == 1)
                {
                    $status = 'CAM';
                    $class='bg-label-info';
                }
                else
                {
                    $status = 'Utility';
                    $class='bg-label-primary';
                }

                return '<s<span class="badge '.$class.' text-capitalize ">' . $status . '</span>';
            })

            ->addColumn('action', function ($query)
            {

                $edit =' <a href="#!" data-size="lg"
                                data-url="'.route('expense.edit', $query->id) .'" 
                                data-ajax-popup="true" class="btn btn-sm btn-primary"
                                data-bs-original-title="User Edit">
                                <i class="ti ti-pencil"></i>
                            </a>';
                $delete = '<a 
                                href="'.route('expense-destroy', $query->id) .'" 
                                 class="btn btn-sm btn-danger"
                                onClick="return confirm(\'Are you sure you want to delete this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="ti ti-trash"></i>
                            </a>';


                return '<div class="btn-group btn-group-xs">'.$edit.$delete.'</div>';
            })
        ->escapeColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }

     public function create()
    {

        $properties = Property::pluck('property_name','id')->toArray();
        return view('expense.create', compact('properties'));
       
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //create new user
    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'price'  => 'required',
            'description'  => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        DB::beginTransaction();
        try {
           
            $saveFile='';
            if ($request->hasFile('receipt')) {
                $file       = $request->receipt;
                $destinationPath    = 'assets/uploads/';
                $fileName = 'receipt-'.time() . '_' . $file->getClientOriginalExtension();
                            
                // Store the file in 'public/assets/uploads' directory
                $path = $file->storeAs($destinationPath, $fileName, 'customer_uploads');

                $saveFile = $destinationPath.$fileName;
            }
            $expense = new Expense;
            $expense->property_id = $request->property_id;
            $expense->type = $request->type;
            $expense->price = $request->price;
            $expense->ex_date = (!empty($request->ex_date)) ? $request->ex_date: date('Y-m-d');
            $expense->description  = $request->description;
            $expense->receipt = $saveFile;
            $expense->note = $request->note;
            $expense->created_by = auth()->user()->id;
            $expense->save();
           
            
            DB::commit();
            return redirect()->route('expense.index')->with('success', __('Expense successfully created.'));
        } catch (\Throwable $e) {
            \Log::error($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
           
        }
    }

     public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $properties = Property::pluck('property_name','id')->toArray();
        return view('expense.edit', compact('expense', 'properties'));
       

    }
     public function update(Request $request, $id)
    {

        $validator = \Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'price'  => 'required',
            'description'  => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        DB::beginTransaction();
        try {
            $expense = Expense::where('id',$id)->first();
        
            if(!$expense)
            {
                return redirect()->back()->with('error','Record not found');
            }

            $saveFile= $request->old_receipt;
            if ($request->hasFile('receipt')) {
                $file       = $request->receipt;
                $destinationPath    = 'assets/uploads/';
                if($request->old_receipt!='')
                {
                    if(file_exists($destinationPath.$request->old_receipt)){
                        unlink($destinationPath.$request->old_receipt);
                    }
                }
               
                $fileName = 'receipt-'.time() . '_' . $file->getClientOriginalExtension();         
                // Store the file in 'public/assets/uploads' directory
                $path = $file->storeAs($destinationPath, $fileName, 'customer_uploads');

                $saveFile = $destinationPath.$fileName;
            }

           
            $expense->property_id = $request->property_id;
            $expense->type = $request->type;
            $expense->price = $request->price;
            $expense->ex_date = (!empty($request->ex_date)) ? $request->ex_date: date('Y-m-d');
            $expense->description  = $request->description;
            $expense->receipt = $saveFile;
            $expense->note = $request->note;
            $expense->created_by = auth()->user()->id;
            $expense->save();

            DB::commit();
            return redirect()->route('expense.index')->with('success', __('Expense successfully updated.'));
        } catch (\Throwable $e) {
            \Log::error($e);
            DB::rollback();
             return redirect()->back()->with('error', $e->getMessage());
        }
    }

     public function destroy($id)
    {
        $expense = Expense::find($id);
        if ($expense) {

            $expense->delete();
            return redirect()->route('expense.index')->with('success', __('Expense successfully deleted .'));
        } else {
            return redirect()->back()->with('error', __('Record not found.'));
        }
        
    }
}
