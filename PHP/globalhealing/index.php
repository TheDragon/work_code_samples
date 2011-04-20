<?
// The guidelines for this application was for a very simple and quick application to manage an iTunes podcast
// for the non-profit organization Global Healing. Application was made to primary user's specifications.

header('Content-type: application/rss+xml');
require_once('include/xml.class.php');
require_once('include/fs.class.php');
$xml = new xml();
print $xml->head();
$live_dir = 'live';
$fs = new fs();
$filenames = $fs->get_titles($live_dir);
foreach ($filenames as $file){
	$item = $fs->process_file("$live_dir/$file");
	print $xml->item($item);
}
print $xml->foot();
?>
