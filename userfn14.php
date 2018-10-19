<?php

// Global user functions
// Page Loading event
function Page_Loading() {

	//echo "Page Loading";
}

// Page Rendering event
function Page_Rendering() {

	//echo "Page Rendering";
}

// Page Unloaded event
function Page_Unloaded() {

	//echo "Page Unloaded";
}
if(!function_exists("get1row")){

	function get1row($s){
		return ew_ExecuteRow($s);
	}
}
if(!function_exists("_query")){

	function _query($sql){
		return ew_ExecuteRows($sql);
	}	
}

function preprint($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function getIdUser(){
	$username = CurrentUserName();
	if($username=="Administrator"){
		return $username;
	}else{
		$query = "select id from karyawan where username='$username'";
		$data = get1row($query);
		return $data['id'];
	}
}

function inKaryawan(){
	$username = CurrentUserName();
	if($username!=''){
		if($username=="Administrator"){
			return "";
		}else{
			$query = "select id,id_user_level from karyawan where username='$username'";
			$data = get1row($query);
			$id = $data['id'];
			if($data['id_user_level']==100){
				return "id='$id'";
			}else{
				return '';
			}
		}
	}
}

function inTicketKaryawan(){
	$username = CurrentUserName();
	if($username!=''){
		if($username=="Administrator"){
			return "";
		}else{
			$query = "select id,id_user_level from karyawan where username='$username'";
			$data = get1row($query);
			$id = $data['id'];
			if($data['id_user_level']==100){
				return "id_karyawan='$id'";
			}else{
				return '';
			}
		}
	}
}
?>
