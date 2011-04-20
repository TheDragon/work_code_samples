<?
class xml{
	function head(){
		$output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
			<rss xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\" version=\"2.0\">
			<channel>
				<ttl>120</ttl>
				<title>Global Healing Podcast</title>
				<link>http://www.globalhealing.net/</link>
				<description>This is the video podcast for Global Healing, showcasing earth benefits and lectures.</description>
				<language>en-us</language>
				<copyright>Copyright (c) 2007-2011 Global Healing</copyright>
				<lastBuildDate></lastBuildDate>
				<itunes:subtitle>Learn more about the state of our environment and what you can do about it.</itunes:subtitle>
				<itunes:author>Global Healing</itunes:author>
				<itunes:summary>This is the video podcast for Global Healing, showcasing earth benefits and lectures.</itunes:summary>
				<itunes:owner>
						<itunes:name>Brian Schremp</itunes:name>
						<itunes:email>brian@schremp.org</itunes:email>
				</itunes:owner>
				<itunes:new-feed-url>http://globalhealing.brainwor.ms</itunes:new-feed-url>
				<itunes:explicit>no</itunes:explicit><itunes:category>Environmental</itunes:category>";
				return trim($output);
	}
	function item($content_array){
		if (!empty($content_array)){
			$output = '<item>';
			$output .= '<title>'.$content_array['title'].'</title>';
			$output .= '<itunes:author>'.$content_array['author'].'</itunes:author>';
			$output .= '<itunes:subtitle>'.$content_array['subtitle'].'</itunes:subtitle>';
			$output .= '<itunes:summary>'.$content_array['summary'].'</itunes:summary>';
			$output .= '<enclosure url="'.$content_array['file_link'].'" length="'.$content_array['file_size'].'" type="video/mp4"/>';
			$output .= '<guid>'.$content_array['file_link'].'</guid>';
			$output .= '<pubDate>'.$content_array['date_published'].'</pubDate>';
			$output .= '<itunes:duration>'.$content_array['duration'].'</itunes:duration>';
			$output .= '<itunes:keywords>'.trim($content_array['keywords']).'</itunes:keywords>';
			$output .= '<itunes:explicit>no</itunes:explicit>';
			$output .= '</item>';
			return $output;
		}
	}
	
	function foot(){
		$output = '</channel></rss>';
		return $output;
	}
}
