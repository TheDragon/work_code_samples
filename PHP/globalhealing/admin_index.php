<?
session_start();
if ((($_POST) && ($_POST['adpass'] == 'admin_password')) || ($_SESSION['omgadmin'] == 'yes')){
	$_SESSION['omgadmin'] = 'yes';
	require_once('include/fs.class.php');
	$fs = new fs();
	$thisthing = array(' ','-');
	$that = array('_','_');
	$files_needing_description = $fs->check_unmatched('live');
	print('<h1>Files that need descriptions</h1>');
	foreach ($files_needing_description as $unfinished_file){
		print('<form name="'.str_replace($thisthing,$that,$unfinished_file).'" method="POST" action="admin_edit.php">');
		print('<input type="hidden" name="edit_file" value="live/'.$unfinished_file.'"/></form>');
		print $unfinished_file.' <a href="#" onclick="document.'.str_replace($thisthing,$that,$unfinished_file).'.submit()">Edit</a><br/>';
	}
	$complete_files = $fs->get_titles('live');
	print('<h1>Files that have descriptions</h1>');
	foreach ($complete_files as $complete_file){
		$values_check = $fs->process_file('live/'.$complete_file);
		if (!empty($values_check)){
			print('<form name="'.str_replace($thisthing,$that,$complete_file).'" method="POST" action="admin_edit.php">');
			print('<input type="hidden" name="edit_file" value="live/'.$complete_file.'"/></form>');
			print $complete_file.' <a href="#" onclick="document.'.str_replace($thisthing,$that,$complete_file).'.submit()">Edit</a><br/>';
		} else {
			$incomplete[] = $complete_file;
		}
	}
	if ($incomplete){
		print('<h1>Files that have incomplete descriptions</h1>');
		foreach ($incomplete as $incomplete_file){
			print('<form name="'.str_replace($thisthing,$that,$incomplete_file).'" method="POST" action="admin_edit.php">');
			print('<input type="hidden" name="edit_file" value="live/'.$incomplete_file.'"/></form>');
			print $incomplete_file.' <a href="#" onclick="document.'.str_replace($thisthing,$that,$incomplete_file).'.submit()">Edit</a><br/>';
		}
	}
} else {
	print('<form action="'.$PHP_SELF.'" method="POST">');
	print('Admin Access Only: <input type="password" name="adpass">');
	print('<input type="submit" value="submit"></form>');
}
