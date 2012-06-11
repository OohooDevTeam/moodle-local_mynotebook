<?php

if (isset($_GET['source'])) exit('<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>OpenTBS plug-in for TinyButStrong - demo source</title></head><body>'.highlight_file(__FILE__,true).'</body></html>');
global $CFG, $USER, $DB;

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');


include_once($CFG->dirroot . '/local/mynotebook/tbs_us/tbs_class.php');
//include_once(dirname(__FILE__).'/tbs_us/tbs_class.php');

include_once($CFG->dirroot . '/local/mynotebook/tbs_plugin_opentbs_1.6.2/tbs_plugin_opentbs.php');
require_once(dirname(__FILE__).'/locallib.php');


$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load OpenTBS plugin

// Read parameters
//This line breaks the ability to download
//if (!isset($_POST['btn_go'])) exit("You must use demo.html");
$suffix = (isset($_POST['suffix']) && (trim($_POST['suffix'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['suffix']) : '';
$debug = (isset($_POST['debug'])) ? intval($_POST['debug']) : 0;

// Retrieve the template to use
$template = (isset($_POST['tpl'])) ? $_POST['tpl'] : '';
$template = basename($template);
$x = pathinfo($template);
$template_ext = $x['extension'];
if (substr($template,0,3)!=='ms_') exit("Wrong file.");
if (!file_exists($template)) exit("File does not exist.");

// Retrieve the name to display
$filename = (isset($_POST['filename'])) ? $_POST['filename'] : '';
$filename = trim(''.$filename);
if ($filename=='') $filename = "(no name)";

// Prepare some data for the demo
//$data = array();
//$data[] = array('firstname'=>'Moodle' , 'name'=>'Moot'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
//$data[] = array('firstname'=>'DJ'  , 'name'=>'MNool'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
//$data[] = array('firstname'=>'Wallas', 'name'=>'King', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );
//$data[] = array('firstname'=>'BNiel', 'name'=>'Larry', 'number'=>'6545y', 'score'=>250);

$note_data = array();

$notes = $DB->get_records('notes', array('userid'=>$USER->id, 'deleted'=>0));

$note_name = array();
$note_content = array();
$courseid = array ();
$course_name = array();
$date_created = array();

foreach ($notes as $note){
    
    $note_name[] = $note->name;
    $note_content[] = strip_tags($note->text);
    $coursenames = $DB->get_records('course', array('id'=>$note->courseid)); 
    $courseid[] = $note->courseid;
    $date_created[] = $note->time_modified;
  
    foreach ($coursenames as $coursename){
    $course_name[] =  $coursename->fullname;
    
    }
}

for ($i=0; $i<sizeof($note_name); $i++){

    $note_data[] = array('notename'=>$note_name[$i], 
                       'course'=>$course_name[$i], 
                       'date_created'=>$date_created[$i],
                       'text'=>$note_content[$i]);
  
}
$data = array();
$data = $note_data;

$x_num = 3152.456;
$x_pc = 0.2567;
$x_dt = mktime(13,0,0,2,15,2010);
$x_bt = true;
$x_bf = false;


// Load the template
$TBS->LoadTemplate($template);

if ($debug==1) {
    // debug mode 1
    $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT);
    exit;
} elseif ($debug==3) {
    // debug mode 3
    $TBS->Plugin(OPENTBS_DEBUG_CHART_LIST);
    exit;
}

// Merge data
$TBS->MergeBlock('b', $data);
$TBS->MergeBlock('c', $note_data);


    $conditions_list= array(TRUE, FALSE, NULL);
    $arrid = array_unique($courseid);
    $arrayid = reorderindex($arrid, $conditions_list);
    
    $arrname = array_unique($course_name);
    $arrayname = reorderindex($arrname, $conditions_list);
    
    $record_amount = array();
    
    for ($j=0; $j<sizeof($arrayid); $j++){
        $record_amount[$j] = $DB->count_records('notes', array('courseid'=>$arrayid[$j], 'deleted'=>0, 'userid'=> $USER->id));
    }
    

// specific merges depending to the docuement
if ($template_ext=='xlsx') {
    // merge cells (exending columns)
    $TBS->MergeBlock('cell1,cell2', $data);
    // change the current sheet
    $TBS->LoadTemplate('#xl/worksheets/sheet2.xml');
    // merge data in Sheet 2
    $TBS->MergeBlock('cell1,cell2', 'num', 3);
    $TBS->MergeBlock('b2', $data);
} elseif ($template_ext=='ods') {
    // no need to change the current sheet, they are all stored in the same XLS subfile.
    // merge data in Sheet 2
    $TBS->MergeBlock('cell1,cell2', 'num', 3);
    $TBS->MergeBlock('b2', $data);
    
} elseif ($template_ext=='docx') {
    // change chart series
    $ChartNameOrNum = 'chart1';
        $SeriesNameOrNum = 1;

        $NewValues = array();
        //Making chart from multidimensional array
        for ($k=0; $k<sizeof($record_amount); $k++){           
            $NewValues[$arrayname[$k]] = $record_amount[$k];                 
        }
        //debugging
//        print_object($arrayname);
//        print_object($record_amount);
//        print_object($NewValues);
//        die();
        
        $NewLegend = "Number of Notes";
        
    $TBS->PlugIn(OPENTBS_CHART, $ChartNameOrNum, $SeriesNameOrNum, $NewValues, $NewLegend);
}

// Define the name of the output file
$file_name = str_replace('.','_'.date('Y-m-d').'.',$template);

// Output as a download file (some automatic fields are merged here)
if ($debug==2) {
    // debug mode 2
    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW);
} elseif ($suffix==='') {
    // download
    $TBS->Show(OPENTBS_DOWNLOAD, $file_name);
} else {
    // save as file
    $file_name = str_replace('.','_'.$suffix.'.',$file_name);
    $TBS->Show(OPENTBS_FILE+TBS_EXIT, $file_name);
}

?>