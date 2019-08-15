<?php

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
        $result      = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header      = substr($result, 0, $header_size);
        $result      = substr($result, $header_size);
        curl_close($ch);
 
        return array(
            'Header' => $header,
            'Result' => $result,
        );
}


$header = getallheaders();
$rowdata = file_get_contents("php://input");
$hmac = hash_hmac('sha1', $rowdata, "bringyourbrain");
if ( isset($header['X-Hub-Signature']) && $header['X-Hub-Signature'] === 'sha1='.$hmac ) {
	$payload = json_decode($rowdata, true);
	$data = "================\n".print_r($payload, true)."\n";
} else {
	$data = "error...\n";
}


file_put_contents("../gege.txt", $data, FILE_APPEND | LOCK_EX)


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
