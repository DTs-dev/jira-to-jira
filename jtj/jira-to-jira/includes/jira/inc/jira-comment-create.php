<?php
			$fileName = __FILE__;

			$jiraInitCommentId = $jiraIssueComment['id'];
			$jiraComment = '*' . $jiraIssueComment['author']['displayName'] . ':* ' . $jiraIssueComment['body'];

			if( !isset( $jiraRecipIssueId ) ) {
				// Get jira-recipient issue id
				include JIRA_INC . 'jira-recipient-issue-get.php';
				if( !isset( $jiraRecipIssueId ) ) {
					include JIRA_INC . 'jira-issue-create.php';
					exit;
				}
			}

			$jiraCloneIssueCommentsDir = $jiraCommentsDir;

			// Post jira issue comment
			jira_connect( $jiraRecipDomain );
			$data = array(
				'body' => $jiraComment
			);
			$jiraIssueId = $jiraRecipIssueId;
			jira_request( 'comment', 'POST', $data );

			// Push jira-recipient comment id to file. (In the full version, ID matches are not configured through file data)
			$jiraRecipCommentId = $requestResult['id'];
			file_put_contents( $jiraCloneIssueCommentsDir . $jiraRecipCommentId . '_' . $jiraInitCommentId . '_' . $jiraRecipIssueId . '_' . $jiraInitIssueId, '' );
?>
