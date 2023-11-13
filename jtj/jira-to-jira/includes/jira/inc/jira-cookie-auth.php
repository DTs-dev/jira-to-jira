<?php
//				$fileName = __FILE__;

				if( isset( $jiraApiToken ) ) {
					$jiraPsswdOrig = $jiraPsswd;
					$jiraPsswd = $jiraApiToken;
				}

				$data = array(
					'username' => $jiraLogin,
					'password' => $jiraPsswd
				);

				if( isset( $jiraApiToken ) ) {
					$jiraPsswd = $jiraPsswdOrig;
				}

				jira_request( 'auth', 'POST', $data );
?>
