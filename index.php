<?php
include_once('signed_request.php');
require 'facebook.php';
//●●はさきほどメモしたID等を入れてください
$facebook = new Facebook(array('appId' => '310952622343585',
  						  'secret' => '800a37eb66b4bcba67d862870a6d8676',
							  'cookie' => true,
						));
$fb_user = $facebook->getUser();

//いいねを押しているかどうか判別
  if ( isset($_POST['signed_request']) ) {
    $fb_data = parse_signed_request($_POST['signed_request'], '310952622343585');
    if( $fb_data['page']['liked'] ){
                
                //いいねとは別にアプリの権限認証をしているかどうか確認する
                //されていなければ、権限認証画面へ転送する
		if (!$fb_user) {
                //scopeの部分はどこまで権限がほしいか任意設定できる
		$par = array('scope' => 'publish_stream','redirect_uri' => 'リダイレクトURL。今回はfacebookページのアドレス。');
    	$fb_login_url = $facebook->getLoginUrl($par);
		
                //javascriptで転送させないと、間にfacebookのロゴが出てくる減少が起こる
		echo "<script type='text/javascript'>top.location.href = '$fb_login_url';</script>";
		}
		
      include_once('fan.php');
                 
    } else {
      include_once('notfan.php');
    }
  }
?>