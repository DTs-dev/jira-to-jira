<?php
		unset( $header );

		$headers = [];

		$objCurl = curl_init();

		curl_setopt( $objCurl, CURLOPT_RETURNTRANSFER, true );

//		if( ( $requestType === 'POST' ) && ( $jiraRequestEntity === 'auth' ) ) {
//			$header[] = 'Authorization: Basic ' . base64_encode( $jiraLogin . ':' . $jiraPsswd );
//		}

		if( in_array( $requestType, array( 'POST', 'PUT' ) ) ) {
			$header[] = 'Content-type: application/json';
			curl_setopt( $objCurl, CURLOPT_POSTFIELDS, json_encode($data) );
		}

		if( ( $requestType === 'POST' ) && ( $jiraRequestEntity === 'attachment' ) ) {
			$header = array( 'Content-Type: multipart/form-data', 'X-Atlassian-Token: no-check' );
			curl_setopt( $objCurl, CURLOPT_POSTFIELDS, $data );
		}

		if( ( $requestType === 'GET' ) && ( $jiraRequestEntity === 'attachment' ) ) {
			set_time_limit(0);
			curl_setopt( $objCurl, CURLOPT_TIMEOUT, 28800 );
			curl_setopt( $objCurl, CURLOPT_FILE, $downloadableFile );
		}

		if( !empty( $jiraOauthToken ) ) {
			// In full version
		}
		else {
			curl_setopt( $objCurl, CURLOPT_COOKIEFILE, JIRA_INC . 'cookie_auth/cookie' );
			curl_setopt( $objCurl, CURLOPT_COOKIEJAR, JIRA_INC . 'cookie_auth/cookie' );
		}

		if( ( $requestType === 'GET' ) && $data ) {
			$jiraRequestUrl .= '?' . http_build_query( $data );
		}

		curl_setopt( $objCurl, CURLOPT_URL, $jiraRequestUrl );
		curl_setopt( $objCurl, CURLOPT_CUSTOMREQUEST, $requestType );

		if( !empty( $jiraOauthToken ) || ( empty( $jiraOauthToken ) && !in_array( $requestType, array( 'GET', 'DELETE' ) ) ) ) {
			curl_setopt( $objCurl, CURLOPT_HTTPHEADER, $header );
		}

//		curl_setopt( $objCurl, CURLOPT_HEADER, true );
		curl_setopt( $objCurl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $objCurl, CURLOPT_SSL_VERIFYHOST, 2 );
//		curl_setopt( $objCurl, CURLOPT_VERBOSE, true );
		curl_setopt( $objCurl, CURLOPT_HEADERFUNCTION,
			function( $objCurl, $respHeader ) use ( &$headers ) {
				$len = strlen( $respHeader );
				$respHeader = explode( ':', $respHeader, 2 );
				if( count( $respHeader ) < 2 ) {
					return $len;
				}
				$headers[strtolower(trim($respHeader[0]))][] = trim($respHeader[1]);
				return $len;
			}
		);

		$requestResponse = curl_exec( $objCurl );

//		$headerSize = curl_getinfo( $objCurl, CURLINFO_HEADER_SIZE );
//		$respHeader = substr( $requestResponse, 0, $headerSize );

//		$requestResponse = substr( $requestResponse, $headerSize );

		if( $jiraRequestEntity !== 'auth' ) {
			$requestResult = json_decode($requestResponse, true);
		}

		include INCLUDES . 'responses-log.php';

		curl_close( $objCurl );
?>
