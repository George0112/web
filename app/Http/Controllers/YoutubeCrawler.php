<?php

namespace App\Http\Controllers;
use Google_Client;
use Google_Service_YouTube;
use DOMDocument;
use SimpleXMLElement;

class YoutubeCrawler
{
	private $videoId;
  public function __construct($videoId=null)
	{
		$this->videoId = $videoId;
	}
 
  public function getInformation()
  {
    $link = "https://www.googleapis.com/youtube/v3/videos?id=".$this->videoId;
    $link .= "&key=AIzaSyAGjI6nBCUK1QAjqWxSuLFdWcv38pKENJ8&part=snippet";
    $video = file_get_contents($link);
      
    $video = json_decode($video, true);
    return $video;
  }

	/**
	 * Returns a list of caption tracks. (captions.listCaptions)
	 *
	 * @param Google_Service_YouTube $youtube YouTube service object.
	 * @param string $videoId The videoId parameter instructs the API to return the
	 * caption tracks for the video specified by the video id.
	 * @param $htmlBody - html body.
	 */
  public function json_prepare_xml($domNode) {
    foreach($domNode->childNodes as $node) {
      if($node->hasChildNodes()) {
        $this->json_prepare_xml($node);
      } else {
        if($domNode->hasAttributes() && strlen($domNode->nodeValue)){
           $domNode->setAttribute("subtitle", $node->textContent);
           $node->nodeValue = "";
        }
      }
    }
  }
	public function getCaptions() {
    $link = "http://video.google.com/timedtext?lang=en&v=".$this->videoId;
    $fileContents = file_get_contents($link);
    $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
    $fileContents = trim(str_replace('"', "'", $fileContents));

    if($fileContents!=null){
      
      $dom = new DOMDocument();
      $dom->loadXML( $fileContents );
      $this->json_prepare_xml($dom);
      $sxml = simplexml_load_string( $dom->saveXML() );
      $captions = json_encode( $sxml );
      
  	  return $captions;
    }
    else{
      return 'null';
    }
    
	}
  

}

?>