<?php
/**
 * Created by PhpStorm.
 * User: gokturk
 * Date: 13.07.2017
 * Time: 20:15:19
 */

$url= "https://secure.payu.com.tr/order/tokens/";
$secret="SECRET_KEY";
//Add PayU Ref. Numbers of transactions for mass token cancellation
$refno = array (
	"357758x",
	"359913x",
	"387556x",
	"359219x",
	"361331x",
	"395744x",
	"388266x",
	"356375x",
	"374511x",
	"364778x",
	"386836x",
	"367141x",
	"376306x",
	"368090x",
	"361677x",
	"371480x",
	"429296x",
	"424132x",
	"435325x",
	"437969x",
	"432699x",
	"449579x",
	"402602x",
	"411750x",
	"430230x",
	"434027x",
	"415076x",
	"442130x",
	"417309x",
	"423254x",
	"419700x",
	"443743x",
	"443826x",
	"481082x",
	"482303x",
	"477821x",
	"499170x",
	"483348x",
	"457483x",
	"468058x",
	"450966x",
	"455080x",
	"470460x",
	"483780x",
	"462076x",
	"469462x",
	"461250x",
	"481418x",
	"475138x",
	"489036x",
	"548008x",
	"543485x",
	"521757x",
	"595174x",
	);
foreach ($refno as $ref) {
	$arParams = array(
		"METHOD"        => 'TOKEN_CANCEL',
		"TIMESTAMP"     => gmdate( 'YmdHis' ),
		"MERCHANT"      => 'OPU_TEST',
		"REF_NO"        => $ref,
		"CANCEL_REASON" => "Cancel Reason Description"
	);
	echo $ref . "\r\n<br>";
	ksort($arParams);
	$hashString = "";

	foreach ($arParams as $v) {
		$hashString .= strlen($v) . $v;
	}

	var_dump($arParams);

	echo $hashString;
	echo $arParams["SIGN"] = hash_hmac("md5", $hashString, $secret);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arParams));
	$response = curl_exec($ch);
	$curlerrcode = curl_errno($ch);
	$curlerr = curl_error($ch);
	if (empty($curlerr) && empty($curlerrcode)) {
		$parsedXML = @simplexml_load_string($response);
		if ($parsedXML !== FALSE) {
			echo "<pre>";
			var_dump($response);
			echo "</pre>";
				}
			}
 else {
		echo "cURL error: " . $curlerr;

	}
}


?>