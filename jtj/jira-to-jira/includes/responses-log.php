<?php
		$code = curl_getinfo( $objCurl, CURLINFO_HTTP_CODE );
		$code=(int)$code;

                if( !in_array($code, [200, 201, 204]) ) {
//			$curlError = curl_error($objCurl);
			$errorLogFile = LOG_DIR . 'jtj.request-warning.log';
			$errors = date("Y-m-d H:i:s") . ' [ERROR] ' . $code . ' ' . $fileName . ': ACTION: ' . $jiraActionType . ': INIT_ISSUE: ' . $_REQUEST['issue_key'] . ': RESPONSE: ' . print_r( $requestResponse, TRUE ) . "\n";
			file_put_contents($errorLogFile, $errors, FILE_APPEND);
                }
?>
