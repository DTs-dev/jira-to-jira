<?php
	error_reporting(E_ALL);

	// Jira Configuration
	require_once JIRA_INC . 'jira-config.php';

	if( ( $_REQUEST['user_id'] === $GLOBALS['jiraLogin'] ) && ( !isset( $requestResult['transition'] ) || ( isset( $requestResult['transition'] ) && !in_array( $requestResult['transition']['transitionName'], $jiraIssueCreatingTransitionNames ) ) ) ) {
		exit;
	}

	// Recipient jira issue create
	if( isset( $requestResult['webhookEvent'] ) ) {
		if( isset( $requestResult['issue_event_type_name'] ) ) {
			if( $requestResult['issue_event_type_name'] === 'issue_created' ) {
				include JIRA_INC . 'jira-issue.php';
				include JIRA_INC . 'jira-issue-create.php';
			} elseif( $requestResult['issue_event_type_name'] === 'issue_commented' ) {
				include JIRA_INC . 'jira-issue.php';
				include JIRA_INC . 'jira-comment-create.php';
			} elseif( $requestResult['issue_event_type_name'] === 'issue_comment_edited' ) {
				include JIRA_INC . 'jira-issue.php';
				include_once JIRA_INC . 'jira-comment-update.php';
			} else {
				include JIRA_INC . 'jira-issue.php';
				include_once JIRA_INC . 'jira-issue-update.php';
			}
		} elseif( $requestResult['webhookEvent'] === 'jira:issue_deleted' ) {
			include JIRA_INC . 'jira-issue.php';
			include_once JIRA_INC . 'jira-issue-delete.php';
		} elseif( $requestResult['webhookEvent'] === 'comment_deleted' ) {
			include_once JIRA_INC . 'jira-comment-delete.php';
		} elseif( $requestResult['webhookEvent'] === 'worklog_created' ) {
			include_once JIRA_INC . 'jira-worklog-create.php';
		} elseif( $requestResult['webhookEvent'] === 'worklog_updated' ) {
			include_once JIRA_INC . 'jira-worklog-update.php';
		} elseif( $requestResult['webhookEvent'] === 'worklog_deleted' ) {
			include_once JIRA_INC . 'jira-worklog-delete.php';
		} elseif( $requestResult['webhookEvent'] === 'issuelink_created' ) {
			include_once JIRA_INC . 'jira-issue-link-add.php';
		} elseif( $requestResult['webhookEvent'] === 'issuelink_deleted' ) {
			include_once JIRA_INC . 'jira-issue-link-delete.php';
		}
	} elseif( isset( $requestResult['transition'] ) ) {
		if( in_array( $requestResult['transition']['transitionName'], $jiraIssueCreatingTransitionNames ) && ( $_REQUEST['user_id'] === $GLOBALS['jiraLogin'] ) ) {
			include JIRA_INC . 'jira-issue.php';
			include_once JIRA_INC . 'jira-set-recipient-issue.php';
		} else {
			include JIRA_INC . 'jira-issue.php';
			include_once JIRA_INC . 'jira-issue-transition.php';
		}
	}
?>
