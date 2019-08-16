<?php
$githubToken = "token";
$githubSecret = "";
$slackWebhookUrl = "webhookurl";
$slackChannel = "#channel";
$organizationId = "";
$projectId = "";
$debug = "";

function createSlackPostOptions($info) {
	return array(
		CURLOPT_URL            => $info['url'],
  	CURLOPT_POST           => true,
  	CURLOPT_POSTFIELDS     => $info['body'],
  	CURLOPT_RETURNTRANSFER => true,
  	CURLOPT_HEADER         => true,
	);
}

function createGitHubGetOptions($url) {
	global $githubToken;
	return array(
		CURLOPT_URL => $url,
		CURLOPT_HTTPHEADER => array(
			'Authorization: token '.$githubToken,
			'Accept: application/vnd.github.inertia-preview+json',
			'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:26.0) Gecko/20100101 Firefox/26.0'
		),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => true
	);
}

function request($options) {
	global $debug;

	$ch = curl_init();
  curl_setopt_array($ch, $options);
  $result = curl_exec($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header      = substr($result, 0, $header_size);
	$result      = substr($result, $header_size);
  curl_close($ch);
	if($debug!="") {
		$data = "==============\n";
		$data .= $options['CURLOPT_URL']."\n";
		$data .= "  ------------\n";
		$data .= $header."\n";
		$data .= "  ------------\n";
		$data .= print_r(json_decode($result,true),true)."\n";
		file_put_contents($debug, $data, FILE_APPEND | LOCK_EX);
	}

  return json_decode($result,true);
}


$header = getallheaders();
$rowdata = file_get_contents("php://input");
$hmac = hash_hmac('sha1', $rowdata, $githubSecret);
$contents = "";
if ( isset($header['X-Hub-Signature']) && $header['X-Hub-Signature'] === 'sha1='.$hmac ) {
	$payload = json_decode($rowdata, true);
	//$data = "================\n".print_r($payload, true)."\n";
	$creator = $payload['project_card']['creator']['login'];
	$creatorUrl = $payload['project_card']['creator']['url'];

	// get card info
	$options = createGitHubGetOptions($payload["project_card"]['url']);
	$res = request($options);
	if(isset($res['content_url'])) { // issue
		$options = createGitHubGetOptions($res['content_url']);
		$res = request($options);
		$noteBody = $res['title'];
		$noteUrl = $res['url'];
		$isNote = false;
	} else { // note
		if(mb_strlen($res['note'])>20) {
			$noteBody = mb_substr($res['note'],0,20)."...";
		} else {
			$noteBody = $res['note'];
		}
		$noteUrl = $res['url'];
		$isNote = true;
	}

	// get projects info
	$options = createGitHubGetOptions($payload["project_card"]['project_url']);
	$res = request($options);
	$projectName = $res['name'];
	$projectUrl = $res['url'];

	// get columns info
	$options = createGitHubGetOptions($payload["project_card"]['column_url']);
	$res = request($options);
	$columnName = $res['name'];

	// changes info
	//  moved : column_id from
	//  edited : note from
	if($payload['action']=='moved') {
		$options = createGitHubGetOptions("https://api.github.com/projects/columns/".$payload["changes"]['column_id']['from']);
		$res = request($options);
		$change = $res['name'];
	} else if($payload['action']=='edited' || $payload['action']=='converted') {
		$change = $payload['changes']['note']['from'];
		if(mb_strlen($change)>20) {
			$change = mb_substr($change,0,20)."...";
		}
	}

	// acction
	switch($payload['action']) {
	case 'created':
		$contents = "project [<".$projectUrl."|".$projectName.">]に以下の<".$noteUrl."|Note>が作成されました\n======\n".$noteBody."\n------\n作成者: <".$creatorUrl."|".$creator.">";
		break;
	case 'edited':
		$contents = "project [<".$projectUrl."|".$projectName.">]のカラム[".$columnName."]の以下の<".$noteUrl."|Note>が編集されました\n======\n".$noteBody."\n------\n編集者: <".$creatorUrl."|".$creator.">";
		break;
	case 'moved':
		if($change!="") {
			if($isNote) {
				$contents = "project [<".$projectUrl."|".$projectName.">]の以下の<".$noteUrl."|Note>が移動されました\n======\n".$noteBody."\n------\n".$change."→".$columnName."\n------\n編集者: <".$creatorUrl."|".$creator.">";
			} else {
				$contents = "project [<".$projectUrl."|".$projectName.">]の以下の<".$noteUrl."|Issue>が移動されました\n======\n".$noteBody."\n------\n".$change."→".$columnName."\n------\n編集者: <".$creatorUrl."|".$creator.">";
			}
		}
		break;
	case 'converted':
		$contents = "project [<".$projectUrl."|".$projectName.">]のカラム[".$columnName."]の以下の<".$noteUrl."|Note>がissue化されました\n======\n".$change."\n------\n編集者: <".$creatorUrl."|".$creator.">";
		break;
	case 'deleted':
		if($isNote) {
			$contents = "project [<".$projectUrl."|".$projectName.">]のカラム[".$columnName."]の以下の<".$noteUrl."|Note>が削除されました\n======\n".$noteBody."\n------\n編集者: <".$creatorUrl."|".$creator.">";
		} else {
			$contents = "project [<".$projectUrl."|".$projectName.">]のカラム[".$columnName."]の以下の<".$noteUrl."|Issue>が削除されました\n======\n".$noteBody."\n------\n編集者: <".$creatorUrl."|".$creator.">";
		}
		break;
	}
} else {
	$data = "error...\n";
}

if($contents) {
	$info = array(
		'url'  => $slackWebhookUrl,
		'body' => array(
	   	'payload' => json_encode(array(
      	'channel'    => $slackChannel,
      	'username'   => "github project",
      	'icon_emoji' => ":thumbsup:",
      	'text'       => $contents,
	    )),
	  ),
	);
	request(createSlackPostOptions($info));

	if($debug!="") {
		file_put_contents($debug, $contents."\n", FILE_APPEND | LOCK_EX);
	}
}
?>
