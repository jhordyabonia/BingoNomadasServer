<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bn extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		
		$this->load->model('bn/Bingo_model','bingo');
		$this->load->model('bn/User_model','user');
	} 
	public function upload()
	{
		$target_path = "./uploads/";
	 
		$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
		
		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
		{
			echo "The file ". basename( $_FILES['uploadedfile']['name']).
			" has been uploaded";
		} else
		{
			echo "There was an error uploading the file, please try again!";
		}
	}
	public function wins()
	{	
		$bingo=$this->bingo->get_all();
		echo "<PRE>";		
		print_r($bingo);
		echo "</PRE>";		
	}
	public function winners()
	{
		$id=$this->input->post('id');
		$bingo=$this->bingo->get(array('id'=>$id));
		$winners->bingo_name=json_decode($bingo->bingo)->bingo_name;
		foreach(explode(',',$bingo->winners) as $key=>$win)
			$winners->tables[$key]= $this->user->get(array('cellular'=>$win));
		echo json_encode($winners);
	}
	public function win()
	{
		$id=$this->input->post('id');
		$cellular=$this->input->post('cellular');
		
		$bingo=$this->bingo->get(array('id'=>$id));
		$_winners=$bingo->winners.",".$cellular;#
		$winners=explode(",",$_winners);#
		$n_winners=count($winners);#
		if($n_winners<=6)
		{
			$tables=json_decode($bingo->tables_winners);#
			
			$tables->tables=(array)$tables->tables;
			$tables->tables[count($tables->tables)-1]=json_decode($this->input->post('tables'));#
			$_tables=json_encode($tables);#
			$array=array('onplay'=>$bingo->onplay.",00","winners"=>$_winners,"tables_winners"=>$_tables);
			$this->bingo->update($array,array('id'=>$id)); 
			echo $n_winners;
			return; 
		}
	} 
	public function onplay()
	{		
		$cel=$this->input->post('cellular');
		$number=$this->input->post('number');
		$bingo=$this->bingo->get($cel);

		$winners=explode(",",$bingo->winners);
		if(count($winners)>4)
		{dei("00");}

		$onplay=$bingo->onplay;
		if($number!=false)
		{
			$onplay.=",".$number;
			$this->bingo->update(array('onplay'=>$onplay),array('id'=>$cel)); 
		}
		$de=explode(",",$onplay);
		echo $de[count($de)-1];
	} 
	public function foto($img)
	{	
		#echo file_get_contents(base_url()."uploads/".$img);
		redirect(base_url()."uploads/".$img);
	}

	public function bingos()
	{echo json_encode($this->bingo->get_all());}
	public function add()
	{echo json_encode($this->user->get($this->input->post('cellular')));}
	public function bingo()
	{
		$cellular=$this->input->post('cellular');
		$_bingo=$this->input->post('bingo');
		$bingo = $this->bingo->get(array('id'=>$cellular));
		if($bingo==false)
			$this->bingo->insert(array('id'=>$cellular,'bingo'=>$_bingo));
		else $this->bingo->update(array('bingo'=>$_bingo,array('id'=>$cellular))); 
		echo json_encode($this->bingo->get(array('id'=>$cellular)));		
	}
	public function singup()
	{
		$usuario['name'] = $this->input->post('name');
		$usuario['cellular'] = $this->input->post('cellular');
		$usuario['email'] = $this->input->post('email');
		$user = $this->user->get(array('cellular'=>$usuario['cellular']));
		if($user!=false)
		{
			if($usuario['name']!="")
				$this->user->update($usuario,$user->id);
		} else $this->user->insert($usuario);
		
		$user = $this->user->get(array('cellular'=>$usuario['cellular']));
		
		echo json_encode($user);
	}
	public function index()
	{	redirect("https://drive.google.com/file/d/0Bw7-14BZUCcveEhvR1h6R0lFd1U/view?usp=sharing");	}
	
}