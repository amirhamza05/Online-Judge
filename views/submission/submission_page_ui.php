


<?php

    $ok=$Submission->checkSubmissionAuth($submissionId);

    if($ok==-1){
        include "404.php";
        return;
    }

    
    $info=array();
    $info['submissionId']=$submissionId;
    $submissionAllInfo=$Submission->getSubmissionAllInfo($info);
    
    $submissionInfo=$submissionAllInfo['submissionInfo'];
    $submissionTestCase=$submissionAllInfo['submissionTestCase'];

    $sourceCodePermission=$ok;
    $testCaseAreaCol=$sourceCodePermission==1?6:12;


    $sourceCode=$submissionInfo['sourceCode'];


?>

<style type="text/css">
    .submissionTd{
        
        padding: 10px 5px 10px 5px;
    }
    .submissionTr{
        border: 2px solid #f5f5f5!important;
    }
    .submissionVerdictTd{
        text-align: right;
        padding-right: 25px;
    }
    .subBody::-webkit-scrollbar {
        width: 0.5em;
        height: 0.5em
    }
    .submissionHeader{
        padding: 10px; 
        font-size: 14px;
    }
    .submissionTd1{
        border-width: 0px;
        background-color: #f5f5f5!important;

    }
    .submissionTd2{
        border-width: 0px!important;
    }

    pre{
        border-radius: 5px;
        border-width: 0px;
        background-color: #ffffff;
    }

    .sourceCodeToggleArea{
        border: 1px solid #E7ECF1;
        padding: 4px 1px 4px 2px;
    }
    .sourceCodeTextArea{
        width: 100%;
        border-width: 0px 1px 1px 1px;
        border-color: #E7ECF1;
        resize: none;
        padding: 2px;
        display: none;

    }

    .sourceCodeTextArea:focus{
          outline: none;
    }

</style>

<script type="text/javascript">
    var submissionId = <?php echo $submissionInfo['submissionId']; ?>;
    var testCaseReady = <?php echo $submissionInfo['testCaseReady']; ?>; 
</script>

<script type="text/javascript" src="views/submission/js/submission.js"></script>

<div class='row'>
    <div class='col-md-12 col-sm-12'>
        <div class="box">
        	<div class="box_header submissionHeader">Submission
            </div>
           	<div class="box_body subBody" style="overflow-x: scroll;scrollbar-width: none;">
                <div id="result"></div>
           		<div style="position: left"></div>
                <table width="100%" id="submission_table" class="">
                	<tr class="submissionTr">
                		<td class="td1 submissionTd submissionTd1">#</td>
                		<td class="td1 submissionTd submissionTd1">Author</td>
                		<td class="td1 submissionTd submissionTd1">Problem</td>
                		<td class="td1 submissionTd submissionTd1">Time</td>
                		<td class="td1 submissionTd submissionTd1">Language</td>
                		<td class="td1 submissionTd submissionTd1">CPU</td>
                		<td class="td1 submissionTd submissionTd1">Memory</td>
                		<td class="td1 submissionTd submissionTd1"></td>
                	</tr>
                	<tr class="submissionTr">
                		<td class="td2 submissionTd submissionTd2"><a href="submission.php?id=<?php echo $submissionInfo['submissionId']; ?>"><?php echo $submissionInfo['submissionId']; ?></a></td>
                		<td class="td2 submissionTd submissionTd2"><a href="profile.php?id=<?php echo $submissionInfo['userId']; ?>"><?php echo $submissionInfo['userHandle']; ?></a></td>
                		<td class="td2 submissionTd submissionTd2"><a href="p.php?id=<?php echo $submissionInfo['problemId']; ?>"><?php echo $submissionInfo['problemName']; ?></a></td>
                		<td class="td2 submissionTd submissionTd2"><?php echo $submissionInfo['submissionTime']; ?></td>
                		<td class="td2 submissionTd submissionTd2"><?php echo $submissionInfo['languageName']; ?></td>
                		<td class="td2 submissionTd submissionTd2" id="submission_cpu"><?php echo $submissionInfo['maxTimeLimit']; ?> s</td>
                		<td class="td2 submissionTd submissionTd2" id="submission_memory"><?php echo $submissionInfo['maxMemoryLimit']; ?> KB</td>
                		<td class="td2 submissionTd submissionTd2 submissionVerdictTd" id="submission_verdict"><?php echo $submissionInfo['judgeStatus']; ?></td>
                	</tr>
            	</table>
           	</div>
        </div>
    </div>
    <div class='col-md-12 col-sm-12'>
    	<div class="box">
    		<div class="box_header submissionHeader">Test Cases</div>
    		<div class="box_body">
    			<table width="100%" id="testCaseTable">
                	<thead>
                    <tr  class="submissionTr">
                		<td class="td1 submissionTd1 submissionTd">#</td>
                		<td class="td1 submissionTd1 submissionTd">CPU</td>
                		<td class="td1 submissionTd1 submissionTd">Memory</td>
                        <td class="td1 submissionTd1 submissionTd">Point</td>
                		<td class="td1 submissionTd1 submissionTd"></td>
                	</tr>
                    </thead>
                    <tbody>
                	<?php 
                        $c=0;
                    foreach ($submissionTestCase as $key => $value) { 
                        $c=$value['testCaseSerialNo'];
                    ?>
                	<tr  class="submissionTr">
                		<td class="td2 submissionTd submissionTd2" id="<?php echo $c ?>_sl"><?php echo $c; ?></td>
                		<td class="td2 submissionTd submissionTd2" id="<?php echo $c ?>_cpu"><?php echo $value['totalTime']; ?> s</td>
                		<td class="td2 submissionTd submissionTd2" id="<?php echo $c ?>_memory"><?php echo $value['totalMemory']; ?> KB</td>
                        <td class="td2 submissionTd submissionTd2" id="<?php echo $c ?>_point"><?php echo $value['point']; ?></td>
                		<td class="td2 submissionTd submissionTd2 submissionVerdictTd" id="<?php echo $c ?>_verdict"><?php echo $value['judgeStatus']; ?></td>
                	</tr>
                	<?php } ?>
                    </tbody>
                </table>
    		</div>
    	</div>
    </div>
    <?php if($sourceCodePermission==1){ ?>
    
  
    
    <div class='col-md-12'>
        <div class="box">
            <div class="box_header submissionHeader">Source Code</div>
            <div class="box_body" style="">
                <div id="submissionSourceCodeEditorArea">
                    <div class="sourceCodeToggleArea">Code: <a onclick="toggleSourceCode()">(Toggle Highlighting)</a> <a onclick="copySourceCode()">(Copy Source Code)</a></div>
                    <?php $sourceCodeLine=substr_count( $sourceCode, "\n" )+1; ?>
                    <textarea id="sourceCodeTextArea" class="sourceCodeTextArea" rows="<?php echo $sourceCodeLine; ?>" readonly="yes"><?php echo $sourceCode; ?></textarea>
                    <div id="sourceCodeText">
                    <?php
                        include_once 'lib/GeSHi-1.0.9.0/geshi/geshi.php';
                        $geshi = new GeSHi($sourceCode, "c++");
                        $geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS,2);
                        $geshi->set_line_style('background: #F5FAFA;', 'background: #ffffff;',true);
                        echo $geshi->parse_code();
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>