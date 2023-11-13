<?php
		// Jira get requests
		if( $jiraRequestEntity === 'issue' ) {
			$jiraRequestUri = '/rest/api/2/issue/' . $jiraIssueId;
		}
		elseif( $jiraRequestEntity === 'jql_issue' ) {
			$jiraRequestUri = '/rest/api/2/search';
			$data = array(
				'jql' => 'project =' . $jiraProjectKey . ' AND cf[' . $jiraIssueExternalIdCfId .'] ~ ' . $jiraIssueId
			);
		}
		elseif( $jiraRequestEntity === 'parent_issue' ) {
			$jiraRequestUri = '/rest/api/2/search';
			$data = array(
				'jql' => 'issue in linkedIssues(' . $jiraIssueId . ') AND issueLinkType = ' . $jiraParentIssueLinkType . ' AND type = ' . $jiraParentIssueType
			);
		}
		elseif( $jiraRequestEntity === 'child_issue' ) {
			$jiraRequestUri = '/rest/api/2/search';
			$data = array(
				'jql' => 'issue in linkedIssues(' . $jiraIssueId . ') AND issueLinkType = ' . $jiraChildIssueLinkType . ' AND type = ' . $jiraChildIssueType . ' AND cf[' . $jiraIssueExternalKeyCfId . '] is EMPTY' . $jiraJqlExtending
			);
		}
		elseif( $jiraRequestEntity === 'worklog' ) {
			$jiraRequestUri = '/rest/tempo-timesheets/4/worklogs/' . $GLOBALS['jiraWorklogId'];
		}
		elseif( $jiraRequestEntity === 'attachment' ) {
			$jiraRequestUri = $jiraAttachmentUrl;
		}
		elseif( $jiraRequestEntity === 'issuetype' ) {
			$jiraRequestUri = '/rest/api/2/issuetype/' . $GLOBALS['jiraIssueTypeId'];
		}
		elseif( $jiraRequestEntity === 'user' ) {
			$jiraRequestUri = '/rest/api/2/user';
			$data = array(
				'username' => $jiraUsername
			);
		}
?>
