<?php

	if (isset($_GET['hub_mode']) && isset($_GET['hub_challenge']) && isset($_GET['hub_verify_token'])) {

		if ($_GET['hub_verify_token'] == 'my_verify_token')

			echo $_GET['hub_challenge'];

	} else {

		$feedData = file_get_contents('php://input');

		$data = json_decode($feedData);

		if ($data->object == "page") {

			$commentID = $data->entry[0]->changes[0]->value->comment_id;

			$message = $data->entry[0]->changes[0]->value->message;

			$verb = $data->entry[0]->changes[0]->value->verb;

			$accessToken = "EAAHeD6gyPVoBAO9ZCbpV8tZBDIHMYrqfWZBoNG70cQOxxcPSJvxtBsUcLQVdBtAuCFIUY1V10FZAKGpTFJwfH01PM8DpPX8Nsp4zshXK0kXq7EGgPxZCg49BIokxPOVnwrTQfcujoWK054S3debVi004sf2nJnvDwy5Ap2HvTtk9LwZBEoLmMK1fRfC05fOZCZAMxUPi5fhy0gZDZD";

			if ($verb == "add") {

				if (strtolower($message) == "red")

					$reply = "Your color is: RED!";

				else if (strtolower($message ) == "blue")

					$reply = "Your color is: BLUE!";

				else

					$reply = "You didn't choose any color!";

				$ch = curl_init();

				curl_setopt($ch, CURLOPT_POST, 1);

				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

				curl_setopt($ch, CURLOPT_POSTFIELDS, "message=$reply&access_token=$accessToken");

				curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v2.10/$commentID/private_replies");

				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36");

				$response = curl_exec($ch);

				curl_close($ch);

			}

		}

	}

	http_response_code(200);

?>
