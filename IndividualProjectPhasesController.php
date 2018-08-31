<?php

namespace App\Http\Controllers;

use App\IndividualProjectPhases;
use Illuminate\Http\Request;

class IndividualProjectPhasesController extends Controller
{
  /*
  Status - 0 == Unbuilt
  Status - 1 == Submitted for review 
  Status - 2 == Approved
  Status - 3 == Declined 
  Status - 4 == Canceled 
  Status - 5 == Built But Unsubmitted for review  or Changes made to the build, but not yet submitted for review
  */
    public function add(Request $r){

        // dd($r->all());
        
        foreach ($r->phases as $key => $value) 
        {
          if($value['project_phase_id'] == '' or $value['cost']=='' or $value['start_date']=='' or $value['end_date']==''){//Check if any phase field was left blank
          return response(['error'=>"No field can be empty"], 404);
          }
          if (isset($value['delete']) && (IndividualProjectPhases::where('project_id', '=', $r->project_id)->where('project_phase_id',$value['project_phase_id'])->exists())) {
              return response(['error'=>'Duplicates Not Permitted'], 404);
          } 
        }
       
        
        IndividualProjectPhases::where('project_id',$r->project_id)->delete();//Clear all the record before reinserting
        foreach ($r->phases as $key => $value) {

               
               	$p_phase = new IndividualProjectPhases;
                if(isset($value['id'])){
                  $p_phase->id = $value['id'];//To ensure existing individual project phases retains their id, but dont do this for new ones
                  $p_phase->status = $value['status'];
                  $p_phase->approved_by = $value['approved_by'];
                  $p_phase->declined_by = $value['declined_by'];
                  $p_phase->canceled_by = $value['canceled_by'];
                  $p_phase->review_submitter = $value['review_submitter'];
                }
               	$p_phase->project_id = $r->project_id;
               	$p_phase->project_phase_id = $value['project_phase_id'];
                $p_phase->cost = $value['cost'];
               	$p_phase->start_date = $value['start_date'];
               	$p_phase->end_date = $value['end_date'];
               	$p_phase->save();
                

            }
            // return "Done";
        return IndividualProjectPhases::with('projectphase:id,name')->where('project_id',$r->project_id)->get()->makeHidden(['created_at','updated_at'])->toArray();
        
      }

      public function delete(Request $r){
        // dd($r->all());
        IndividualProjectPhases::where('id',$r->id)->delete();
        return IndividualProjectPhases::with('projectphase:id,name')->where('project_id',$r->project_id)->get()->makeHidden(['created_at','updated_at'])->toArray();

      }

      public function get(Request $request){//Used for the project costing
        // dd($request->all());
        $columns = ['id','project_phase_id','status'];

        $length = $request->params['length'];
        $column = $request->params['column'];
        $dir = $request->params['dir'];
        $searchValue = $request->params['search'];

        
        $query = IndividualProjectPhases::with('projectphase:id,name','expense_record','phase_labour.material_and_service','project','phase_material.material_and_service')->where('project_id',$request->id)->orderBy($columns[$column], $dir);


        if($searchValue)
        {
            $query->where('id', 'like', '%' . $searchValue . '%')
                  ->orWhereHas('projectphase', function($q) use ($searchValue){
                      $q->where('name',  'like', '%' . $searchValue . '%');
                  })->get();
        }


        $projects = $query->paginate($length);
        // dd($projects);
        return ['data' => $projects, 'draw' => $request->params['draw']];

      }

      public function review(Request $r){
        // dd($r->all());
        IndividualProjectPhases::where('id', $r->id)->update(['status' => 1,'review_submitter'=> \Auth::user()->id]); 
        return "okay";
      }

      public function approve(Request $r){
        // dd($r->all());
        IndividualProjectPhases::where('id', $r->id)->update(['status' => 2,'approved_by'=> \Auth::user()->id]); //Approve Project Phase
        return "okay";
      }

      public function decline(Request $r){
        // dd($r->all());
        IndividualProjectPhases::where('id', $r->id)->update(['status' => 3,'declined_by'=> \Auth::user()->id]); //decline Project Phase
        return "okay";
      }

      public function cancel(Request $r){
        // dd($r->all());
        IndividualProjectPhases::where('id', $r->id)->update(['status' => 4,'canceled_by'=> \Auth::user()->id]); //cancel Project Phase
        return "okay";
      }

      public function singleGet(Request $r){

        // dd($r->all());
          return IndividualProjectPhases::with('projectphase:id,name')->where('id',$r->id)->get()->makeHidden(['created_at','updated_at'])->toArray();
      }

      public function getProjectPhases(Request $r){

        // return $r->all();
          return IndividualProjectPhases::with('projectphase:id,name')->where('project_id',$r->data)->where('status',2)->get()->makeHidden(['created_at','updated_at'])->toArray();
      }
}
