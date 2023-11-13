<?php
		// Jira post requests
		if( $jiraRequestEntity === 'auth' ) {
			$jiraRequestUri = '/rest/auth/1/session';
		}
		if( $jiraRequestEntity === 'issue' ) {
			$jiraRequestUri = '/rest/api/2/issue';
		}
		elseif( $jiraRequestEntity === 'transition' ) {
			$jiraRequestUri = '/rest/api/2/issue/' . $jiraIssueId . '/transitions';
		}
		elseif( $jiraRequestEntity === 'attachment' ) {
			$jiraRequestUri = '/rest/api/2/issue/' . $jiraIssueId . '/attachments';
		}
		elseif( $jiraRequestEntity === 'comment' ) {
			$jiraRequestUri = '/rest/api/2/issue/' . $jiraIssueId . '/comment';
		}
		elseif( $jiraRequestEntity === 'worklog' ) {
			$jiraRequestUri = '/rest/tempo-timesheets/4/worklogs';
		}
		elseif( $jiraRequestEntity === 'issueLink' ) {
			$jiraRequestUri = '/rest/api/2/issueLink';
		}
?>
