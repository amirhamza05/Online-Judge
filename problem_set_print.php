<link rel="stylesheet" type="text/css" href="style/css/problem.css">
<link rel="stylesheet" type="text/css" href="style/css/color.css">
<link rel="stylesheet" type="text/css" href="style/lib/bootstrap/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Exo 2" rel="stylesheet">

<style type="text/css">
	.problemSet{
		padding: 20px;
	}
	.logoArea{
		border: 2px solid #CCCCCC;
		border-width: 0px 0px 1px 0px;
		margin-bottom: 15px;
		padding-bottom: 10px;
	}
	.logo{
		font-size: 70px;
		font-weight: bold;
		text-align: center;
		font-family: "Exo 2";
	}
	.logoImg{
		height: 80px;
		width: 80px;
		margin-top: -30px;
	}
</style>

<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8">
<div class="problemSet">
<div class="logoArea">
	<div class="logo"><img src="file/site_metarial/favicon.png" class="logoImg">oderOJ</div>
</div>
<?php
	include "script.php";
	$problemId=isset($_GET['id'])?$_GET['id']:10;
	$problemData=$Problem->getProblemInfo($problemId);
	$problemData['problemName']=$problemData['problemId'].". ".$problemData['problemName'];
	$ProblemFormat->buildProblemFormat($problemData);


?>

</div>

</div>
</div>