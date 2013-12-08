<?php
/*
 * The page shown when the user requests to print this form. This page automatically prints itsself, and closes its parent browser window.
 */

/* for $GLOBALS[], ?? */
require_once('../../globals.php');
/* for acl_check(), ?? */
require_once($GLOBALS['srcdir'].'/api.inc');
/* for generate_form_field, ?? */
require_once($GLOBALS['srcdir'].'/options.inc.php');

/** CHANGE THIS - name of the database table associated with this form **/
$table_name = 'dap';

/** CHANGE THIS name to the name of your form. **/
$form_name = 'DAP';

/** CHANGE THIS to match the folder you created for this form. **/
$form_folder = 'dap';

/* Check the access control lists to ensure permissions to this page */
$thisauth = acl_check('patients', 'med');
if (!$thisauth) {
 die($form_name.': Access Denied.');
}
/* perform a squad check for pages touching patients, if we're in 'athletic team' mode */
if ($GLOBALS['athletic_team']!='false') {
  $tmp = getPatientData($pid, 'squad');
  if ($tmp['squad'] && ! acl_check('squads', $tmp['squad']))
   $thisauth = 0;
}
/* Use the formFetch function from api.inc to load the saved record */
$xyzzy = formFetch($table_name, $_GET['id']);

/* in order to use the layout engine's draw functions, we need a fake table of layout data. */
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

$returnurl = $GLOBALS['concurrent_layout'] ? 'encounter_top.php' : 'patient_encounter.php';


/* define check field functions. used for translating from fields to html viewable strings */

function chkdata_Txt(&$record, $var) {
        return htmlspecialchars($record{"$var"},ENT_QUOTES);
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>

<!-- declare this document as being encoded in UTF-8 -->
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" ></meta>

<!-- supporting javascript code -->
<!-- for dialog -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot']; ?>/library/dialog.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot']; ?>/library/textformat.js"></script>

<!-- Global Stylesheet -->
<link rel="stylesheet" href="<?php echo $css_header; ?>" type="text/css"/>
<!-- Form Specific Stylesheet. -->
<link rel="stylesheet" href="../../forms/<?php echo $form_folder; ?>/style.css" type="text/css"/>
<title><?php echo htmlspecialchars('Print '.$form_name); ?></title>

</head>
<body class="body_top">

<div class="print_date"><?php xl('Printed on ','e'); echo date('F d, Y', time()); ?></div>

<form method="post" id="<?php echo $form_folder; ?>" action="">
<div class="title"><?php xl($form_name,'e'); ?></div>

<!-- container for the main body of the form -->
<div id="print_form_container">
<fieldset>

<!-- display the form's manual based fields -->
<table border='0' cellpadding='0' width='100%'>
<tr><td class='sectionlabel'><input type='checkbox' id='form_cb_m_1' value='1' data-section="1stpart" checked="checked" />1stpart</td></tr><tr><td><div id="print_1stpart" class='section'><table>
<!-- called consumeRows 014--> <!--  generating 4 cells and calling --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Provider','e').':'; ?></td><td class='text data' colspan='3'><?php echo generate_form_field($manual_layouts['providername'], $xyzzy['providername']); ?></td><!--  generating empties --><td class='emptycell' colspan='1'></td></tr>
<!-- called consumeRows 014--> <!--  generating 4 cells and calling --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Type Of Therapy','e').':'; ?></td><td class='text data' colspan='3'><?php echo generate_form_field($manual_layouts['typeoftherapy'], $xyzzy['typeoftherapy']); ?></td><!--  generating empties --><td class='emptycell' colspan='1'></td></tr>
<!-- called consumeRows 014--> <!--  generating 4 cells and calling --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Codes Billed','e').':'; ?></td><td class='text data' colspan='3'><?php echo generate_form_field($manual_layouts['cpt'], $xyzzy['cpt']); ?></td><!--  generating empties --><td class='emptycell' colspan='1'></td></tr>
<!-- called consumeRows 014--> <!--  generating 4 cells and calling --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Client','e').':'; ?></td><td class='text data' colspan='3'><?php echo generate_form_field($manual_layouts['client'], $xyzzy['client']); ?></td><!--  generating empties --><td class='emptycell' colspan='1'></td></tr>
<!-- called consumeRows 014--> <!-- just calling --><!-- called consumeRows 224--> <!--  generating 4 cells and calling --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Date','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['dos'], $xyzzy['dos']); ?></td><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Location','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['location'], $xyzzy['location']); ?></td><!--  generating empties --><td class='emptycell' colspan='1'></td></tr>
<!-- called consumeRows 014--> <!-- just calling --><!-- called consumeRows 224--> <!--  generating 4 cells and calling --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Duration','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['duration'], $xyzzy['duration']); ?></td><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Start Time','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['starttime'], $xyzzy['starttime']); ?></td><!--  generating empties --><td class='emptycell' colspan='1'></td></tr>
<!-- called consumeRows 014--> <!-- generating not($fields[$checked+1]) and calling last --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('End Time','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['endtime'], $xyzzy['endtime']); ?></td><!-- called consumeRows 214--> <!-- Exiting not($fields) and generating 2 empty fields --><td class='emptycell' colspan='1'></td></tr>
</table></div>
</td></tr> <!-- end section 1stpart -->
<tr><td class='sectionlabel'><input type='checkbox' id='form_cb_m_2' value='1' data-section="treatment" checked="checked" />Treatment</td></tr><tr><td><div id="print_treatment" class='section'><table>
<!-- called consumeRows 014--> <!-- just calling --><!-- called consumeRows 224--> <!-- generating not($fields[$checked+1]) and calling last --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Treatment Goal #','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['txgoal1'], $xyzzy['txgoal1']); ?></td><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['txgoal2'], $xyzzy['txgoal2']); ?></td><!-- called consumeRows 424--> <!-- Exiting not($fields) and generating 0 empty fields --></tr>
</table></div>
</td></tr> <!-- end section treatment -->
<tr><td class='sectionlabel'><input type='checkbox' id='form_cb_m_3' value='1' data-section="dapnote" checked="checked" />DAP Note</td></tr><tr><td><div id="print_dapnote" class='section'><table>
<!-- called consumeRows 014--> <!-- just calling --><!-- called consumeRows 224--> <!--  generating 4 cells and calling --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Data','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['data'], $xyzzy['data']); ?></td><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Assessment','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['assassment'], $xyzzy['assassment']); ?></td><!--  generating empties --><td class='emptycell' colspan='1'></td></tr>
<!-- called consumeRows 014--> <!-- generating not($fields[$checked+1]) and calling last --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Plan','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['plan'], $xyzzy['plan']); ?></td><!-- called consumeRows 214--> <!-- Exiting not($fields) and generating 2 empty fields --><td class='emptycell' colspan='1'></td></tr>
</table></div>
</td></tr> <!-- end section dapnote -->
<tr><td class='sectionlabel'><input type='checkbox' id='form_cb_m_4' value='1' data-section="signature" checked="checked" />Signature</td></tr><tr><td><div id="print_signature" class='section'><table>
<!-- called consumeRows 014--> <!-- generating not($fields[$checked+1]) and calling last --><td class='fieldlabel' colspan='1'><?php echo xl_layout_label('Provider','e').':'; ?></td><td class='text data' colspan='1'><?php echo generate_form_field($manual_layouts['provider'], $xyzzy['provider']); ?></td><!-- called consumeRows 214--> <!-- Exiting not($fields) and generating 2 empty fields --><td class='emptycell' colspan='1'></td></tr>
</table></div>
</td></tr> <!-- end section signature -->
</table>


</fieldset>
</div><!-- end print_form_container -->

</form>
<script type="text/javascript">
window.print();
window.close();
</script>
</body>
</html>

