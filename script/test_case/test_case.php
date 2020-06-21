<?php
class TestCase {
   	
   	public $inputFilePath = "user_file/test_case/input/";
   	public $outputFilePath = "user_file/test_case/output/";
//starting connection
 	public function __construct(){
     	$this->DB=new Database();
     	$this->conn=$this->DB->conn;
     	$this->SiteHash=new SiteHash();
     	$this->Site=new Site();
 	}

 	public function getInputFilePath($testCaseHash){
 		return $this->inputFilePath.$testCaseHash.'.txt';
 	}

 	public function getOutputFilePath($testCaseHash){
 		return $this->outputFilePath.$testCaseHash.'.txt';
 	}

 	public function getTestCaseHashId($testCaseId){
 		return $this->SiteHash->getHash($testCaseId);;
 	}

 	public function getTestCaseList($problemId,$json=false){
 		$sql="select testCaseId,userHandle,userId,testCaseAddedDate,testCaseIdHash from test_case 
 		natural join users
 		where problemId=$problemId";
 		$data=$this->DB->getData($sql);
 		foreach ($data as $key => $value) {
 			$testCaseHash=$value['testCaseIdHash'];
 			$value['inputUrl']=$this->getInputFilePath($testCaseHash);
 			$value['outputUrl']=$this->getOutputFilePath($testCaseHash);
 			$value['inputFileSize']=filesize($value['inputUrl']);
 			$value['outputFileSize']=filesize($value['outputUrl']);
 			$data[$key]=$value;
 		}

 		return $json?json_encode($data):$data;
 	}

 	public function addTestCase($info){
 		if($this->DB->isLoggedIn==0){
 			echo "User Is Not Logged In";
 			return;
 		}

 		$info['input'] = $this->getFieldTxtData($info['inputData']);
 		$info['output'] = $this->getFieldTxtData($info['outputData']);
 		//print_r($info);
 		//return;
 		$data=array();
 		$data['problemId']=$info['problemId'];
 		$data['testCaseAddedDate']=$this->DB->date();
 		$data['userId']=$this->DB->isLoggedIn;
 		$responce=$this->DB->pushData("test_case","insert",$data);
 		if($responce['error']==0){
 			$testCaseHash = $this->getTestCaseHashId($responce['insert_id']);
 			$this->addInputOutput($testCaseHash,$info['input'],$info['output']);
 			$hash_data=array();
 			$hash_data['testCaseIdHash']=$testCaseHash;
 			$hash_data['testCaseId']=$responce['insert_id'];
 			$this->DB->pushData("test_case","update",$hash_data);
 		}
 		print_r($responce);
 	}

 	public function getFieldTxtData($info){
 		$txt = "";
 		if($info['editorType']=="editor" || $info['editorType']=='upload')$txt = $info['text'];
 		else if($info['editorType']=="url")
 			$txt = $this->Site->getFileData($info['url']);
 		return $txt;
 	}

 	public function addInputOutput($testCaseHash,$input,$output){
 		$fileName=$testCaseHash.".txt";
 		//echo "$file_name";
 		$this->Site->createFile($this->inputFilePath,$fileName,$input);
 		$this->Site->createFile($this->outputFilePath,$fileName,$output);
 	}

 	public function updateTestCase($info){
 		$testCaseHashId=$info['testCaseHashId'];
 		$info['input'] = $this->getFieldTxtData($info['inputData']);
 		$info['output'] = $this->getFieldTxtData($info['outputData']);
 		file_put_contents($this->getInputFilePath($testCaseHashId), $info['input']);
 		file_put_contents($this->getOutputFilePath($testCaseHashId), $info['output']);
 	}


 	public function deleteTestCase($testCaseHash){
 		if($this->DB->isLoggedIn==0)return;
 		$sql="select testCaseId from test_case where testCaseIdHash='$testCaseHash'";
 		$data=$this->DB->getData($sql);
 		if(!isset($data[0]))return;
 		$data=$data[0];
 		$this->DB->pushData("test_case","delete",$data);
 		unlink($this->getInputFilePath($testCaseHash));
 		unlink($this->getOutputFilePath($testCaseHash));
 		
 	}

 	public function getTestCaseData($testCaseHash){
 		$data=array();
 		$data['input']=$this->Site->readFile($this->getInputFilePath($testCaseHash));
 		$data['output']=$this->Site->readFile($this->getOutputFilePath($testCaseHash));
		return $data;
 	}
 	
}
?>