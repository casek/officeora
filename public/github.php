<?php
$githubToken = "token";

function createOptions($info) {
	return array(
		CURLOPT_URL            => $info['url'],
  	CURLOPT_POST           => true,
  	CURLOPT_POSTFIELDS     => $info['body'],
  	CURLOPT_RETURNTRANSFER => true,
  	CURLOPT_HEADER         => true,
	);
}

function request($options) {
	$ch = curl_init();
  curl_setopt_array($ch, $options);
  $result = curl_exec($ch);
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header      = substr($result, 0, $header_size);
	$result      = substr($result, $header_size);
  curl_close($ch);

  return json_decode($result,true);
}


$header = getallheaders();
$rowdata = file_get_contents("php://input");
$hmac = hash_hmac('sha1', $rowdata, "bringyourbrain");
if ( isset($header['X-Hub-Signature']) && $header['X-Hub-Signature'] === 'sha1='.$hmac ) {
	$payload = json_decode($rowdata, true);
	//$data = "================\n".print_r($payload, true)."\n";
	$creator = $payload['project_card']['creator']['login'];
	$creatorUrl = $payload['project_card']['creator']['url'];

	// get card info
	$options = array(
		CURLOPT_URL => $payload["project_card"]['url'],
		CURLOPT_HTTPHEADER => array(
			'Authorization: token '.$githubToken,
			'Accept: application/vnd.github.inertia-preview+json',
			'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:26.0) Gecko/20100101 Firefox/26.0'
		),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => true
	);
	$res = request($options);
	if(mb_strlen($res['note'])>20) {
		$noteBody = mb_substr($res['note'],0,20);
	} else {
		$noteBody = $res['note'];
	}
	$noteUrl = $res['url'];

	// get projects info
	$options = array(
		CURLOPT_URL => $payload["project_card"]['project_url'],
		CURLOPT_HTTPHEADER => array(
			'Authorization: token '.$githubToken,
			'Accept: application/vnd.github.inertia-preview+json',
			'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:26.0) Gecko/20100101 Firefox/26.0'
		),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => true
	);
	$res = request($options);
	$projectName = $res['name'];
	$projectUrl = $res['url'];

	// get columns info
	$options = array(
		CURLOPT_URL => $payload["project_card"]['column_url'],
		CURLOPT_HTTPHEADER => array(
			'Authorization: token '.$githubToken,
			'Accept: application/vnd.github.inertia-preview+json',
			'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:26.0) Gecko/20100101 Firefox/26.0'
		),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => true
	);
	$res = request($options);
	$columnName = $res['name'];

	// changes info
	//  moved : column_id from
	//  edited : note from
	if($payload['action']=='moved') {
		$options = array(
			CURLOPT_URL => "https://api.github.com/projects/columns/".$payload["changes"]['column_id']['from'],
			CURLOPT_HTTPHEADER => array(
				'Authorization: token '.$githubToken,
				'Accept: application/vnd.github.inertia-preview+json',
				'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:26.0) Gecko/20100101 Firefox/26.0'
			),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => true
		);
		$res = request($options);
		$change = $res['name'];
	} else if($payload['action']=='edited') {
		$change = $payload['changes']['note']['from'];
	}

	// acction
	$contents = "";
	switch($payload['action']) {
	case 'created':
		$contents = "project [<".$projectUrl."|".$projectName.">]に以下の<".$noteUrl."|Note>が作成されました\n======\n".$noteBody."\n------\n作成者: <".$creatorUrl."|".$creator.">";
		break;
	case 'edited':
		$contents = "project [<".$projectUrl."|".$projectName.">]のカラム[".$columnName."]の以下の<".$noteUrl."|Note>が編集されました\n======\n".$noteBody."\n------\n編集者: <".$creatorUrl."|".$creator.">";
		break;
	case 'moved':
		if($changes!=$columnName) {
			$action = "カラム移動されました";
			$contents = "project [<".$projectUrl."|".$projectName.">]の以下の<".$noteUrl."|Note>が移動されました\n======\n".$noteBody."\n------\n".$change."→".$columnName."\n------\n編集者: <".$creatorUrl."|".$creator.">";
		}
		break;
	case 'converted':
		$contents = "project [<".$projectUrl."|".$projectName.">]のカラム[".$columnName."]の以下の<".$noteUrl."|Note>がissue化されました\n======\n".$noteBody."\n------\n編集者: <".$creatorUrl."|".$creator.">";
		break;
	case 'deleted':
		$contents = "project [<".$projectUrl."|".$projectName.">]のカラム[".$columnName."]の以下の<".$noteUrl."|Note>が削除されました\n======\n".$noteBody."\n------\n編集者: <".$creatorUrl."|".$creator.">";
		break;
	}



} else {
	$data = "error...\n";
}


file_put_contents("../gege.txt", $contents."\n", FILE_APPEND | LOCK_EX)


/*
$info = array(
	'url'  => "https://hooks.slack.com/services/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",
	'body' => array(
   	'payload' => json_encode(array(
          	'channel'    => "#say_something",
          	'username'   => "github project",
          	'icon_emoji' => ":thumbsup:",
          	'text'       => "gege
gege",
    )),
  ),
);

$ret = request(createOptions($info));
*/
?>
