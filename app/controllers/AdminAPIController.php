<?php

class AdminAPIController extends BaseController{

    public function __construct()
    {
        
    } 
    

    public function get_branches_by_channel_id($id)
	{
		return Branch::where("channel_id","=",$id)->lists("name","id");
	}

	public function get_sections_by_branch_id($id)
	{
		return Section::where("branch_id","=",$id)->orderBy("sequence")->lists("name","id");
	}

	public function get_boxes_by_branch_id($id)
	{
		return Box::where("branch_id","=",$id)->whereNull("section_id")->select("id",DB::raw('CONCAT(name," - ",type ) AS name'))->lists("name","id");
	}

	public function get_simcard_pattern_list($length)
	{
		return SimcardPattern::where("length","=",$length)->orderBy("pattern","asc")->lists("pattern");
	}

	public function check_duplicate_channel(){
		$channel = Channel::where('reg_no',Input::get('reg_no'))->first();
		
		return Input::has('reg_no')&&isset($channel)?'true':'false';
	}
    
    public function check_duplicate_brand(){
		$brand = Brand::where('name',Input::get('name'))->first();
		
		return Input::has('name')&&isset($brand)?'true':'false';
	}
    
    public function check_duplicate_type(){
		$type = Type::where('type_code',Input::get('type_code'))->first();
		
		return Input::has('type_code')&&isset($type)? 'true':'false';
	}
	
}
?>