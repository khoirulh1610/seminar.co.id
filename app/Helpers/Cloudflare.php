<?php
namespace App\Helpers;

class Cloudflare{
	static function dns()
	{
		$curl = curl_init();
		curl_setopt_array($curl, [
		CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/327338b2dab99d97af739c8d6eebcb28/dns_records",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_POSTFIELDS => "",
		// CURLOPT_COOKIE => "__cflb=0H28vgHxwvgAQtjUGU4vq74ZFe3sNVUZaBWKx96PShs; __cfruid=43bcaff57609dcbe147067bd947b4041caa61415-1645376691",
		CURLOPT_HTTPHEADER => [
			"Authorization: Bearer 4a46b3a6dfffa3aaa79dedd7f9fe3f732aef7",
			"Content-Type: application/json",
			"X-Auth-Email: khoirulh1610@gmail.com",
			"X-Auth-Key: 4a46b3a6dfffa3aaa79dedd7f9fe3f732aef7",
			"X-Auth-User-Service-Key: v1.0-e229b791aee2dc3455ab4854-2477e6f108bfd681daa053c9e1a43032da14d9eab257ce4c1b483c92fdcd9bc339a9c2ee0ba6db5200268ef66539ca65b54742e5559ceec40773042227651966d101471613647e"
		],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		echo "cURL Error #:" . $err;
		} else {
		echo $response;
		}
	}

	static function	add_dns($sub_domain){
		$curl = curl_init();
		curl_setopt_array($curl, [
		CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/327338b2dab99d97af739c8d6eebcb28/dns_records",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "{\"type\":\"A\",\"name\":\"$sub_domain\",\"content\":\"194.233.68.179\",\"ttl\":3600,\"priority\":10,\"proxied\":true}",
		// CURLOPT_COOKIE => "__cflb=0H28vgHxwvgAQtjUGU4vq74ZFe3sNVUZaBWKx96PShs; __cfruid=43bcaff57609dcbe147067bd947b4041caa61415-1645376691",
		CURLOPT_HTTPHEADER => [
			"Authorization: Bearer 4a46b3a6dfffa3aaa79dedd7f9fe3f732aef7",
			"Content-Type: application/json",
			"X-Auth-Email: khoirulh1610@gmail.com",
			"X-Auth-Key: 4a46b3a6dfffa3aaa79dedd7f9fe3f732aef7",
			"X-Auth-User-Service-Key: v1.0-e229b791aee2dc3455ab4854-2477e6f108bfd681daa053c9e1a43032da14d9eab257ce4c1b483c92fdcd9bc339a9c2ee0ba6db5200268ef66539ca65b54742e5559ceec40773042227651966d101471613647e"
		],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		echo "cURL Error #:" . $err;
		} else {
		echo $response;
		}
	}

	static function remove_dns($id){
		$curl = curl_init();
		curl_setopt_array($curl, [
		CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/327338b2dab99d97af739c8d6eebcb28/dns_records/".$id,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "DELETE",
		CURLOPT_POSTFIELDS => "",
		// CURLOPT_COOKIE => "__cflb=0H28vgHxwvgAQtjUGU4vq74ZFe3sNVUZaBWKx96PShs; __cfruid=43bcaff57609dcbe147067bd947b4041caa61415-1645376691",
		CURLOPT_HTTPHEADER => [
			"Authorization: Bearer 4a46b3a6dfffa3aaa79dedd7f9fe3f732aef7",
			"Content-Type: application/json",
			"X-Auth-Email: khoirulh1610@gmail.com",
			"X-Auth-Key: 4a46b3a6dfffa3aaa79dedd7f9fe3f732aef7",
			"X-Auth-User-Service-Key: v1.0-e229b791aee2dc3455ab4854-2477e6f108bfd681daa053c9e1a43032da14d9eab257ce4c1b483c92fdcd9bc339a9c2ee0ba6db5200268ef66539ca65b54742e5559ceec40773042227651966d101471613647e"
		],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		echo "cURL Error #:" . $err;
		} else {
		echo $response;
		}
	}
}