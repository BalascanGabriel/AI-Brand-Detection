<?php

$handle=fopen("$target_file", "rb");
$content=fread($handle, filesize("$target_file"));

$method="POST";
$url="https://servert3.cognitiveservices.azure.com/vision/v3.2/analyze?visualFeatures=Brands";
$data=$content;
fclose($handle);

$curl=curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
if($data)
   curl_setopt($curl, CURLOPT_POSTFIELDS, $data);


curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'User-Agent: PostmanRuntime/7.28.0',
			'Accept-Encoding: gzip, deflate, br',
			'Connection: keep-alive',
			'Ocp-Apim-Subscription-Key: 3547af0e86b3471a864648f8c11af57f',
			'Content-type: image/jpeg'
));	

curl_setopt($curl, CURLINFO_HEADER_OUT, true);
curl_setopt($curl, CURLOPT_HEADER, 1);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result=curl_exec($curl);
$curl_info=curl_getinfo($curl);
curl_close($curl);
$header_size=$curl_info['header_size'];
$header=substr($result, 0, $header_size);
$body=substr($result, $header_size);

file_put_contents("result.json", $body);
$dataaa=file_get_contents("result.json");

$obj = json_decode($dataaa, true);
echo PHP_EOL;
$brand_gasit="";
foreach($obj['brands'] as $res) 
   $brand_gasit=$res['name'];

?>
