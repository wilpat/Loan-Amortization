<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\PurchaseRequisition;
use App\PurchaseRequisitionMaterial;
use App\ProjectMaterial;

class PurchaseRequisitionController extends Controller
{
    /*
		Status == 0 -- New
		Status == 1 -- Pending
		Status == 2 -- Approved
		Status == 3 -- Processed
		Status == 4 -- Declined
		Status == 5 -- Canceled
		Status == 6 -- Delivered
		Status == 7 -- Paid
		Status == 8 -- Attention

    */
	public function get(Request $request){//Used for the purchase requisition
    // dd($request->all());
    $columns = ['id','user_id','date','individual_project_phases_id'];

    $length = $request->params['length'];
    $column = $request->params['column'];
    $dir = $request->params['dir'];
    $searchValue = $request->params['search'];

    
    $query = PurchaseRequisition::with('user:id,first_name,last_name','purchase_requisition_materials.expense_records_amount','purchase_requisition_materials.vendor.vendorservice','individual_project_phase.projectphase:id,name','purchase_requisition_materials.project_material','project:id,name')->where('project_id',$request->id)->orderBy($columns[$column], $dir);

    if($searchValue)
    {
        $query->where('id', 'like', '%' . $searchValue . '%')
        	  ->orWhere('date', 'like', '%' . $searchValue . '%')
              ->orWhereHas('user', function($q) use ($searchValue){
                  $q->where('first_name',  'like', '%' . $searchValue . '%');
                  $q->orWhere('last_name',  'like', '%' . $searchValue . '%');
              })->orWhereHas('individual_project_phase', function($q) use ($searchValue){
                  $q->whereHas('projectphase', function($q) use ($searchValue){
                      $q->where('name',  'like', '%' . $searchValue . '%');
                  });
              })->get();
    }


    $requisitions = $query->paginate($length);
    // dd($projects);
    return ['data' => $requisitions, 'draw' => $request->params['draw']];
  }

  public function add(Request $r){
    // dd($r->requisition);
    if($r->materials == [])
    {//Check if the data is null
      return response(['error'=>"No attached material"], 404);
    } 

    foreach ($r->materials as $key => $value) 
    {
      if(($value['material_and_services_id']=='' && $value['project_material_id']=='') or $value['quantity']==''){//Check if any material field was left blank
      return response(['error'=>"No field can be empty"], 404);
      }
      //Check if this user has requested this purchase material before for this phase
      /*if (PurchaseRequisitionMaterial::join('purchase_requisitions','purchase_requisition_materials.purchase_requisition_id','purchase_requisitions.id')->where('purchase_requisition_materials.project_material_id',$value['project_material_id'])->where('purchase_requisitions.user_id',$r->requisition['requester'])->where('purchase_requisitions.individual_project_phases_id',$r->requisition['individual_project_phases_id'])->exists()) {
          return response(['error'=>'You attached a material that already exists for this user'], 404);
      }*/

      //This would pose an issue cos if we prevent this duplicate, if you need extra material of which you have previously requested, you're to go into the requisition containing the material, and then increase the amount which can work find but management might want to track the date when that extra was made, which wouldnt be possible this way
    }

    // Create Purchase Requisition
    $input = [
            'project_id' => $r->requisition['project_id'],
            'date' => $r->requisition['date'],
            'user_id' => $r->requisition['requester'],
            'individual_project_phases_id' => $r->requisition['individual_project_phases_id'],
            'note' => $r->requisition['note'],
            'created_by' => \Auth::user()->id,
        ];
    $pr_id = PurchaseRequisition::create($input)->id;
    // If materials come from what was captured in the project 
    if ($r->requisition['in_budget']) {

      foreach ($r->materials as $key => $value)
      {

        $pr_material = new PurchaseRequisitionMaterial;
        $pr_material->purchase_requisition_id = $pr_id;
        $pr_material->project_material_id = $value['project_material_id'];
        $pr_material->quantity = $value['quantity'];
        $pr_material->save();        

      }

    }
    else
    {
      foreach ($r->materials as $key => $value)
      {
        //Create a project material for this material being requested for this particular phase
        $input = [
          'individual_project_phases_id' => $r->requisition['individual_project_phases_id'],        
          'material_and_services_id' => $value['material_and_services_id'],
          'quantity' => $value['quantity'],
          'extra' => 1
        ];
        $p_id = ProjectMaterial::create($input)->id;

        //Then Create a purchase requisition material record using the created project material id
        $pr_material = new PurchaseRequisitionMaterial;
        $pr_material->purchase_requisition_id = $pr_id;
        $pr_material->project_material_id = $p_id;
        $pr_material->quantity = $value['quantity'];
        $pr_material->save();

      }
    }
    return "Okay";

  }

  public function get_view(Request $r){
    // dd($r->all());
    return PurchaseRequisition::with('user:id,first_name,last_name','purchase_requisition_materials.vendor.vendorservice','individual_project_phase.projectphase:id,name','individual_project_phase.phase_material.material_and_service:id,name','purchase_requisition_materials.project_material','project:id,name')->where('id',$r->id)->get();
  }

  public function update(Request $r)
  {
          // dd($r->all());
         $pr = PurchaseRequisition::find($r->id);
         $pr->user_id = $r->requester;
         $pr->date = $r->date;
         $pr->note = $r->note;
         $pr->active = $r->active;
         $pr->save();
      
      
      return $pr::with('user:id,first_name,last_name','purchase_requisition_materials.vendor.vendorservice','individual_project_phase.projectphase:id,name','individual_project_phase.phase_material.material_and_service:id,name','purchase_requisition_materials.project_material','project:id,name')->where('id',$r->id)->get();
  }


}
