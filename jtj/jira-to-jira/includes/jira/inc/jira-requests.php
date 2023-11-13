<?php
function jira_request( $jiraRequestEntity, $requestType = 'GET', $data = NULL ) {
	global $fileName, $headers, $requestResult, $jiraUrl, $jiraConsumerKey, $jiraPrivateKeyFile, $jiraOauthToken, $jiraLogin, $jiraPsswd, $jiraRequestUrl, $jiraActionType, $jiraAttachmentUrl, $downloadableFile, $jiraJqlExtending, $jiraUsername, $jiraProjectKey, $jiraIssueId, $jiraIssueExternalIdCfId, $jiraIssueExternalKeyCfId, $jiraParentIssueType, $jiraChildIssueType, $jiraParentIssueLinkType, $jiraChildIssueLinkType, $jiraIssueSummary, $jiraAttachmentId, $jiraIssueLinkId;

	$jiraActionType = $jiraRequestEntity . '-' . $requestType;

	if( $requestType === 'GET' ) {
		include JIRA_INC . 'jira-get.php';
	}
	elseif( $requestType === 'POST' ) {
		include JIRA_INC . 'jira-post.php';
	}
	elseif( $requestType === 'PUT' ) {
		include JIRA_INC . 'jira-put.php';
	}
	elseif( $requestType === 'DELETE' ) {
		include JIRA_INC . 'jira-delete.php';
	}

	$jiraRequestUrl = $jiraUrl . $jiraRequestUri;

	if( ( $requestType === 'GET' ) && ( $jiraRequestEntity === 'attachment' ) ) {
		$jiraRequestUrl = $jiraRequestUri;
	}

	if( !empty( $jiraOauthToken ) ) {
		// In full version
	}
	else {
		include JIRA_INC . 'curl.php';
	}
}
?>
