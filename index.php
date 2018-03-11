<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'WuyPwewrGv5OZmjWIfydJDJDG/JP9AUqVs/gIZSovHkZ5Z+6PJBmDIcdDBYEut8ZhKX1nll/ENXYWXJoHuqyot2/RPpVWLEsWhMkLXMs+AAlt0Npi4mCWfS+a4Wr0Wqa8kKkuUIaRwJZ+79GvR37wQdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = '2eac7280fbe6bd78d099f11325563b8f
';//Your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];

if($message['type']=='sticker')
{	
	$balas = array(
	'UserID' => $profil->userId,	
        'replyToken' => $replyToken,							
	'messages' => array(
array(
	'type' => 'text',									
	'text' => 'Terima Kasih Stikernya.'										
	)
	)
	);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = '213238ca-57fe-446f-bf98-436b9eada4a0'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] == 404)
	{
		$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Mohon Gunakan Bahasa Indonesia Yang Benar :D.'
									)
							)
						);
				
	}
else
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Maaf '.$profil->displayName.' Server Kami Sedang Sibuk Sekarang.'
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);
