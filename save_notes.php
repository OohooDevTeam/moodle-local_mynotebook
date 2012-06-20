<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
      global $DB,$CFG, $USER;
      
$test = $_POST['test'];

if (isset($test)){  
    ECHO $test;
    $note = $DB->get_record('notes', array('id'=>$id, 'deleted'=>0, 'userid'=> $USER->id));
    $note->name = $title;
    $note->text = $text;
} else {
    ECHO"!SET";
    
}

?>
