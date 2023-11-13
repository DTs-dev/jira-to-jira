<?php
//			$jiraIssueFilterField = 'id';
			jira_connect( $jiraRecipDomain );
			$jiraIssueId = $jiraInitIssueId;
			jira_request( 'jql_issue' );
			if( isset( $requestResult['issues'][0]['id'] ) ) {
				$jiraRecipIssueId = $requestResult['issues'][0]['id'];
			}
?>
