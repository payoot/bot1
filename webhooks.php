<?php 








require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');
$access_token = '7c6FPGLU6nsP3QE5d2s9pgju85poaZND45AMRWi73nijCeQ5OYk8lY6H0e/Jwu5tSw9cS+PbexnZ5nNAVA8ZmjFpnS9+mKrf6tCcOB/0SAySm6KfTXkYkjTg4Kcfl3mckYT0hPn9IYGzQrtcLeFODAdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
$post = json_encode($data);
$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
$events = json_decode($content, true);

if (!is_null($events['events'])) {
    foreach ($events['events'] as $event) {
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            $text = $event['message']['text'];
            echo $text;
             $replyToken = $event['replyToken'];

                // set url สำหรับดึงข้อมูล 
            curl_setopt($ch, CURLOPT_URL, "http://data.tmd.go.th/api/WeatherToday/V1/?type=json"); 

            //return the transfer as a string 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

            // ตัวแปร $output เก็บข้อมูลทั้งหมดที่ดึงมา 
            $output = curl_exec($ch); 
            
        
    

            // ปิดการเชื่อต่อ
            curl_close($ch);    
            // output ออกไปครับ
            echo $output;
            $messages = [
				'type' => 'text',
				'text' => $text
            ];
            $url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
            ];
            $post = json_encode($data);
            $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            echo $result . "\r\n";
        }
    }
}