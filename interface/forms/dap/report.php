<?php
/*
 * this file's contents are included in both the encounter page as a 'quick summary' of a form, and in the medical records' reports page.
 */

/* for $GLOBALS[], ?? */
require_once('../../globals.php');
/* for acl_check(), ?? */
require_once($GLOBALS['srcdir'].'/api.inc');
/* for generate_display_field() */
require_once($GLOBALS['srcdir'].'/options.inc.php');
/* The name of the function is significant and must match the folder name */
function dap_report( $pid, $encounter, $cols, $id) {
    $count = 0;
/** CHANGE THIS - name of the database table associated with this form **/
$table_name = 'dap';


/* an array of all of the fields' names and their types. */
$field_names = array('providername' => 'dropdown_list','typeoftherapy' => 'checkbox_list','cpt' => 'checkbox_list','client' => 'textfield','dos' => 'textfield','location' => 'checkbox_list','duration' => 'textfield','starttime' => 'textfield','endtime' => 'textfield','txgoal1' => 'textfield','txgoal2' => 'checkbox_list','data' => 'textarea','assassment' => 'textarea','plan' => 'textarea','provider' => 'provider');/* in order to use the layout engine's draw functions, we need a fake table of layout data. */
$manual_layouts = array( 
 'providername' => 
   array( 'field_id' => 'providername',
          'data_type' => '1',
          'fld_length' => '0',
          'description' => 'Provider',
          'list_id' => 'provider' ),
 'typeoftherapy' => 
   array( 'field_id' => 'typeoftherapy',
          'data_type' => '21',
          'fld_length' => '0',
          'description' => '',
          'list_id' => 'typeoftherapy' ),
 'cpt' => 
   array( 'field_id' => 'cpt',
          'data_type' => '21',
          'fld_length' => '0',
          'description' => '',
          'list_id' => 'cpt' ),
 'client' => 
   array( 'field_id' => 'client',
          'data_type' => '2',
          'fld_length' => '10',
          'max_length' => '15',
          'description' => 'Clients Name',
          'list_id' => '' ),
 'dos' => 
   array( 'field_id' => 'dos',
          'data_type' => '2',
          'fld_length' => '10',
          'max_length' => '15',
          'description' => 'Date of Service',
          'list_id' => '' ),
 'location' => 
   array( 'field_id' => 'location',
          'data_type' => '21',
          'fld_length' => '0',
          'description' => 'Date Of Service',
          'list_id' => 'location' ),
 'duration' => 
   array( 'field_id' => 'duration',
          'data_type' => '2',
          'fld_length' => '10',
          'max_length' => '15',
          'description' => 'Duration',
          'list_id' => '' ),
 'starttime' => 
   array( 'field_id' => 'starttime',
          'data_type' => '2',
          'fld_length' => '10',
          'max_length' => '15',
          'description' => 'Start Time',
          'list_id' => '' ),
 'endtime' => 
   array( 'field_id' => 'endtime',
          'data_type' => '2',
          'fld_length' => '10',
          'max_length' => '15',
          'description' => 'End Time',
          'list_id' => '' ),
 'txgoal1' => 
   array( 'field_id' => 'txgoal1',
          'data_type' => '2',
          'fld_length' => '10',
          'max_length' => '15',
          'description' => 'Goal of treatment',
          'list_id' => '' ),
 'txgoal2' => 
   array( 'field_id' => 'txgoal2',
          'data_type' => '21',
          'fld_length' => '0',
          'description' => 'txgoal',
          'list_id' => 'txgoal' ),
 'data' => 
   array( 'field_id' => 'data',
          'data_type' => '3',
          'fld_length' => '175',
          'max_length' => '5',
          'description' => '',
          'list_id' => '' ),
 'assassment' => 
   array( 'field_id' => 'assassment',
          'data_type' => '3',
          'fld_length' => '175',
          'max_length' => '5',
          'description' => '',
          'list_id' => '' ),
 'plan' => 
   array( 'field_id' => 'plan',
          'data_type' => '3',
          'fld_length' => '175',
          'max_length' => '5',
          'description' => '',
          'list_id' => '' ),
 'provider' => 
   array( 'field_id' => 'provider',
          'data_type' => '10',
          'fld_length' => '0',
          'description' => 'Staff Member',
          'list_id' => '' )
 );
/* an array of the lists the fields may draw on. */
$lists = array();
    $data = formFetch($table_name, $id);
    if ($data) {

        echo '<table><tr>';

        foreach($data as $key => $value) {

            if ($key == 'id' || $key == 'pid' || $key == 'user' ||
                $key == 'groupname' || $key == 'authorized' ||
                $key == 'activity' || $key == 'date' || 
                $value == '' || $value == '0000-00-00 00:00:00' ||
                $value == 'n')
            {
                /* skip built-in fields and "blank data". */
	        continue;
            }

            /* display 'yes' instead of 'on'. */
            if ($value == 'on') {
                $value = 'yes';
            }

            /* remove the time-of-day from the 'date' fields. */
            if ($field_names[$key] == 'date')
            if ($value != '') {
              $dateparts = split(' ', $value);
              $value = $dateparts[0];
            }

	    echo "<td><span class='bold'>";
            

            if ($key == 'providername' ) 
            { 
                echo xl_layout_label('Provider').":";
            }

            if ($key == 'typeoftherapy' ) 
            { 
                echo xl_layout_label('Type Of Therapy').":";
            }

            if ($key == 'cpt' ) 
            { 
                echo xl_layout_label('Codes Billed').":";
            }

            if ($key == 'client' ) 
            { 
                echo xl_layout_label('Client').":";
            }

            if ($key == 'dos' ) 
            { 
                echo xl_layout_label('Date').":";
            }

            if ($key == 'location' ) 
            { 
                echo xl_layout_label('Location').":";
            }

            if ($key == 'duration' ) 
            { 
                echo xl_layout_label('Duration').":";
            }

            if ($key == 'starttime' ) 
            { 
                echo xl_layout_label('Start Time').":";
            }

            if ($key == 'endtime' ) 
            { 
                echo xl_layout_label('End Time').":";
            }

            if ($key == 'txgoal1' ) 
            { 
                echo xl_layout_label('Treatment Goal #').":";
            }

            if ($key == 'txgoal2' ) 
            { 
                echo xl_layout_label('').":";
            }

            if ($key == 'data' ) 
            { 
                echo xl_layout_label('Data').":";
            }

            if ($key == 'assassment' ) 
            { 
                echo xl_layout_label('Assessment').":";
            }

            if ($key == 'plan' ) 
            { 
                echo xl_layout_label('Plan').":";
            }

            if ($key == 'provider' ) 
            { 
                echo xl_layout_label('Provider').":";
            }

                echo '</span><span class=text>'.generate_display_field( $manual_layouts[$key], $value ).'</span></td>';

            $count++;
            if ($count == $cols) {
                $count = 0;
                echo '</tr><tr>' . PHP_EOL;
            }
        }
    }
    echo '</tr></table><hr>';
}
?>

