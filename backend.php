<?php
	
if($_POST['action']=="getAllQ"){
	$conn=connect();
	returnAllQuestions();
}
else if($_POST['action']=="getSomeQ"){
	$conn=connect();
	returnSomeQuestions($_POST['id']);
}
else if($_POST['action']=="getOneQ"){
	$conn= connect();
	echo returnQuestion($_POST['id']);
}
else if($_POST['action']=="insertQ"){
	$conn=connect();
	insertQuestion($_POST);
}

mysql_close($conn);

function returnSomeQuestions($list){
	$returnArray=array();
	$arrLength = count($list);
	for($i = 0; $i < $arrLength; $i++){
		array_push($returnArray, returnQuestion($list[$i]));
	}
	echo json_encode($returnArray);
}
function returnAllQuestions(){
	$tArray=array();
	$query="select id from serializedQuestions";
	($result=mysql_query($query) or die(mysql_error()));
	while($row = mysql_fetch_assoc($result)){
		array_push($tArray, $row['id']);
	}
	$returnArray=array();
	foreach($tArray as $t){
		array_push($returnArray, returnQuestion($t));
	}
	echo json_encode($returnArray);
}
function returnQuestion($Qid){
	$query="select * from serializedQuestions where id=$Qid";
	($result=mysql_query($query) or die(mysql_error()));
	$row=mysql_fetch_assoc($result);
	$obj = unserialize($row['object']);
	$obj->__set('id', $row['id']);
	return $obj->toJson();
}
function insertQuestion($postArray){
	$temp=new question($postArray);
	$serial=serialize($temp);
	$tempDate=$temp->__get('date');
	$query="insert into serializedQuestions (object, date) VALUES ('$serial', '$tempDate')";
	($result=mysql_query($query) or die(mysql_error()));
}
function connect(){
	#connect to DB
	$servername="sql.njit.edu";
	$user="fdm8";
	$password="dnPvZprB";
	($conn=mysql_connect($servername, $user, $password) or die(mysql_error())); 
	$query="use fdm8";
	($result=mysql_query($query) or die(mysql_error()));
	return $conn;
}
class question{
private $output;
private $method;
private $variables=array();
private $type;
private $value;
private $problem;
private $answer;
private $id;
private $date;

	public function __construct($postArray){

		if($postArray != null){
		$this->output=$postArray['output'];
		$this->method=$postArray['method'];
		$this->variables=$postArray['variables'];
		$this->type=$postArray['type'];
		$this->value=$postArray['value'];
		$this->problem=$postArray['problem'];
		$this->answer=$postArray['answer'];
		$temp=getdate();
		$this->date=$temp['hours'].":".$temp['minutes']." ".$temp['mon']."/".$temp['mday']."/".$temp['year'];
		}
	}
	public function __set($property, $value){
		$this->$property=$value;
	}
	public function __get($property){
		return $this->$property;
	}
	public function printout(){
		var_dump($this);
	}
	public function toJson(){
		$arr=array('output'=>$this->output, 'method'=>$this->method, 'variables'=>$this->variables, 'type'=>$this->type, 'value' => $this->value, 'problem' => $this->problem, 'answer'=>$this->answer, 'date'=>$this->date, 'id'=>$this->id);
		return json_encode($arr);
	}
}
	
?>

