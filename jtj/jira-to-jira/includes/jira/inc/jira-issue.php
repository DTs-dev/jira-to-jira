<?php
		$fileName = __FILE__;

		// IDs fields
		$jiraInitIssueId = $requestResult['issue']['id'];
		$jiraInitIssueKey = $requestResult['issue']['key'];
		if( !empty( $requestResult['issue']['fields']['customfield_'.$jiraIssueExternalIdCfId] ) ) {
			$jiraRecipIssueId = $requestResult['issue']['fields']['customfield_'.$jiraIssueExternalIdCfId];
		}
		if( !empty( $requestResult['issue']['fields']['customfield_'.$jiraIssueExternalKeyCfId] ) ) {
			$jiraRecipIssueKey = $requestResult['issue']['fields']['customfield_'.$jiraIssueExternalKeyCfId];
		}

		// Default fields
		$jiraIssueSummary = $requestResult['issue']['fields']['summary'];
		$jiraIssueDescription = $requestResult['issue']['fields']['description'];
		$jiraIssueReporter = $requestResult['issue']['fields']['reporter']['name'];
		$jiraIssueAssignee = $requestResult['issue']['fields']['assignee']['name'];
		$jiraIssuePriorityName = $requestResult['issue']['fields']['priority']['name'];
		
		if( isset( $requestResult['issue']['fields']['fixVersions'][0] ) ) {
			$jiraIssueFixVersionsArrays = $requestResult['issue']['fields']['fixVersions'];
			foreach( $jiraIssueFixVersionsArrays as $jiraIssueFixVersionsArray ) {
				$jiraIssueFixVersions[] = array( 'name' => $jiraIssueFixVersionsArray['name'] );
			}
		} else {
			$jiraIssueFixVersions = [];
		}

		if( isset( $requestResult['issue']['fields']['components'][0] ) ) {
			$jiraIssueComponentsArrays = $requestResult['issue']['fields']['components'];
			foreach( $jiraIssueComponentsArrays as $jiraIssueComponentsArray ) {
				$jiraIssueComponents[] = array( 'name' => $jiraIssueComponentsArray['name'] );
			}
		} else {
			$jiraIssueComponents = [];
		}

		if( isset( $requestResult['issue']['fields']['customfield_'.$jiraReleaseCfId][0] ) ) {
			$jiraIssueReleasesArrays = $requestResult['issue']['fields']['customfield_'.$jiraReleaseCfId];
			foreach( $jiraIssueReleasesArrays as $jiraIssueReleaseArray ) {
				$jiraIssueReleases[] = array( 'name' => $jiraIssueReleaseArray['name'] );
			}
		} else {
			$jiraIssueReleases = [];
		}

		$jiraIssueAttachments = $requestResult['issue']['fields']['attachment'];
		if( !empty( $requestResult['issue']['fields']['duedate'] ) ) {
			$jiraIssueDueDate = $requestResult['issue']['fields']['duedate'];
		} else {
			$jiraIssueDueDate = NULL;
		}

//		if( isset( $requestResult['issue']['fields']['timetracking']['remainingEstimate'] ) ) {
//			$jiraIssueRemainingEstimate = $requestResult['issue']['fields']['timetracking']['remainingEstimate'];
//		} else {
//			$jiraIssueRemainingEstimate = NULL;
//		}
//		if( isset( $requestResult['issue']['fields']['timetracking']['originalEstimate'] ) ) {
//			$jiraIssueOriginalEstimate = $requestResult['issue']['fields']['timetracking']['originalEstimate'];
//		} else {
//			$jiraIssueOriginalEstimate = NULL;
//		}

		if( !empty( $requestResult['issue']['fields']['comment']['comments'] ) ) {
			$jiraIssueComments = $requestResult['issue']['fields']['comment']['comments'];
		}

		if( !empty( $requestResult['comment'] ) ) {
			$jiraIssueComment = $requestResult['comment'];
		}

		if( !empty( $requestResult['issue']['fields']['worklog']['worklogs'] ) ) {
			$jiraIssueWorklogs = $requestResult['issue']['fields']['worklog']['worklogs'];
		}

		if( isset( $requestResult['changelog']['items'][0]['field'] ) && ( $requestResult['changelog']['items'][0]['field'] === 'Attachment' ) ) {
			if( empty( $requestResult['changelog']['items'][0]['to'] ) ) {
				$jiraAttachmentDeleted = true;
				$jiraInitAttachmentId = $requestResult['changelog']['items'][0]['from'];
			} else {
				$jiraInitAttachments = $requestResult['changelog']['items'];
			}
		}

		// Custom fields
		if( !empty( $requestResult['issue']['fields']['customfield_'.$jiraStartCfId] ) ) {
			$jiraIssueStart = $requestResult['issue']['fields']['customfield_'.$jiraStartCfId];
		} else {
			$jiraIssueStart = NULL;
		}
		if( !empty( $requestResult['issue']['fields']['customfield_'.$jiraEndCfId] ) ) {
			$jiraIssueEnd = $requestResult['issue']['fields']['customfield_'.$jiraEndCfId];
		} else {
			$jiraIssueEnd = NULL;
		}
		$jiraTempoAccountId = $requestResult['issue']['fields']['customfield_'.$jiraTempoAccountCfId]['name'];

		// Checking to valid issue type
		$jiraIssueTypeId = $requestResult['issue']['fields']['issuetype']['id'];
		jira_request( 'issuetype' );
		$jiraIssueTypeName = $requestResult['name'];
		if( !in_array( $jiraIssueTypeName, $jiraValidIssueTypes ) ) {
			exit;
		}
		// Jira's child issue type
		if( in_array( $jiraIssueTypeName, array( $jiraBugIssueTypeName, $jiraBugfixIssueTypeName ) ) ) {
			$jiraChildIssueType = $jiraIssueTypeName;
		}

		// Transition
		if( isset( $requestResult['transition']['transitionId'] ) ) {
			$jiraIssueTransitionId = $requestResult['transition']['transitionId'];
		}
?>
