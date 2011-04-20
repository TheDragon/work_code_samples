<?
session_start();
print('<a href="/admin_index.php">Back to the list</a>');
if (($_POST['edit_file']) && ($_SESSION['omgadmin'] == 'yes') && (!$_POST['write_file'])){
	require_once('include/fs.class.php');
	$fs = new fs();
	if (file_exists($_POST['edit_file'].'.txt')){
		$file = $_POST['edit_file'];
		$complete = array();
		$complete = $fs->process_file($_POST['edit_file']);
		if (empty($complete)){
			print('<h1>Editing '.$_POST['edit_file'].'</h1>');
			print('<form action="'.$PHP_SELF.'" method="POST">');
			print('<b>Title:</b><input type="text" name="title"/><br/>');
			print('<b>Summary:</b><input type="text" name="summary"/><br/>');
			print('<b>Subtitle:</b><input type="text" name="subtitle"/><br/>');
			print('<b>Author:</b><input type="text" name="author"/><br/>');
			print('<input type="hidden" name="edit_file" value="'.$_POST['edit_file'].'"/>');
			print('<b>Duration(mm,ss):</b><input type="text" name="duration"/><br/>');
			print('<b>Keywords(separate with commas):</b><input type="text" name="keywords"/><br/>');
			print('<input type="submit" value="Post it" name="write_file"/></form>');
		} else {
			print('<h1>Editing '.$_POST['edit_file'].'</h1>');
			print('<form action="'.$PHP_SELF.'" method="POST">');
			print('<b>Title:</b><input type="text" value="'.$complete['title'].'" name="title"/><br/>');
			print('<b>Summary:</b><input type="text" value="'.$complete['summary'].'" name="summary"/><br/>');
			print('<b>Subtitle:</b><input type="text" value="'.$complete['subtitle'].'" name="subtitle"/><br/>');
			print('<b>Author:</b><input type="text" value="'.$complete['author'].'" name="author"/><br/>');
			print('<input type="hidden" name="edit_file" value="'.$_POST['edit_file'].'"/>');
			print('<b>Duration(mm,ss):</b><input type="text" value="'.$complete['duration'].'" name="duration"/><br/>');
			print('<b>Keywords(separate with commas):</b><input type="text" value="'.$complete['keywords'].'" name="keywords"/><br/>');
			print('<input type="submit" value="Post it" name="write_file"/></form>');	
		}
		
	} else {
		print('<h1>Editing '.$_POST['edit_file'].'</h1>');
		print('<form action="'.$PHP_SELF.'" method="POST">');
		print('<b>Title:</b><input type="text" name="title"/><br/>');
		print('<b>Summary:</b><input type="text" name="summary"/><br/>');
		print('<b>Subtitle:</b><input type="text" name="subtitle"/><br/>');
		print('<b>Author:</b><input type="text" name="author"/><br/>');
		print('<b>Duration(mm,ss):</b><input type="text" name="duration"/><br/>');
		print('<input type="hidden" name="edit_file" value="'.$_POST['edit_file'].'"/>');
		print('<b>Keywords(separate with commas):</b><input type="text" name="keywords"/><br/>');
		print('<input type="submit" value="Post it" name="write_file"/></form>');
	}
} elseif (($_POST['write_file']) && ($_SESSION['omgadmin'] == 'yes')) {
	$write_string = $_POST['title'].':'.$_POST['summary'].':'.$_POST['subtitle'].':'.$_POST['author'].':'.str_replace(':',',',$_POST['duration']).':'.$_POST['keywords'];
	if (file_put_contents($_POST['edit_file'].'.txt',$write_string)){
		print('File updated successfully');
	} else {
		print('File failed to update');
	}
} else {
	print('<form action="/admin_index.php" method="POST">');
	print('Admin Access Only: <input type="password" name="adpass">');
	print('<input type="submit" value="submit"></form>');
}
