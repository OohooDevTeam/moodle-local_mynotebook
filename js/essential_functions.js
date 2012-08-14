/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function call_to_export() {


function export_option(str)
{
if (str=='')
  {
  document.getElementById('Show_option').innerHTML='';
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById('Show_option').innerHTML=xmlhttp.responseText;
    }
  }
  console.log(str);
xmlhttp.open('GET','export.php?q='+str ,true);
xmlhttp.send();
}


}


//Retrieves the notes that the user wants to merge together
function merge() {


function merge_notes_left()
{

    var source = $('select#merge_left').val();
    console.log(source);
        console.log($('select#merge_left'));

    var destination = $('select#merge_right').val();
    console.log(destination);
        console.log($('select#merge_right'));



    $('#Merge_result').load('mergenotes.php', {'source': source, 'destination': destination});


}


//Select all the boxes
function check_all() {



      checked = false;
      function checkedAll () {
        if (checked == false){
        checked = true
        } else {
        checked = false
        }
	for (var i = 0; i < document.getElementById('check').elements.length; i++) {
	  document.getElementById('check').elements[i].checked = checked;
	}
        console.log('Grabbed All IDs')
      }
}
}
