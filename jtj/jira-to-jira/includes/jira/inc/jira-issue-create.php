<?php
			$fileName = __FILE__;

			// Create jira issue
			jira_connect( $jiraRecipDomain );

			$jiraCloneIssueAttachmentsDir = $jiraAttachmentsDir;

			$data = array(
				'fields' => array(
					'summary' => $jiraIssueSummary,
					'description' => $jiraIssueDescription,
					'issuetype' => array( 'name' => $jiraIssueTypeName ),
					'reporter' => array( 'name' => $jiraIssueReporter ),
                                        'assignee' => array( 'name' => $jiraIssueAssignee ),
					'project' => array( 'key' => $jiraProjectKey ),
					'priority' => array( 'name' => $jiraIssuePriorityName ),
					'fixVersions' => $jiraIssueFixVersions,
					'components' => $jiraIssueComponents,
					'duedate' => $jiraIssueDueDate,
//					'timetracking' => array(
//						'remainingEstimate' => $jiraIssueRemainingEstimate,
//						'originalEstimate' => $jiraIssueOriginalEstimate
//					),
					'customfield_'.$jiraIssueExternalIdCfId => $jiraInitIssueId,
					'customfield_'.$jiraIssueExternalKeyCfId => $jiraInitIssueKey,
					'customfield_'.$jiraReleaseCfId => $jiraIssueReleases,
					'customfield_'.$jiraStartCfId => $jiraIssueStart,
					'customfield_'.$jiraEndCfId => $jiraIssueEnd
				)
			);
			if( empty( $jiraIssueDescription ) ) {
				unset( $data['fields']['description'] );
			}
			if( !$jiraIssueReleases ) {
				unset( $data['fields']['customfield_'.$jiraReleaseCfId] );
			}
			if( !$jiraIssueDueDate ) {
				unset( $data['fields']['duedate'] );
			}
			if( !$jiraIssueFixVersions ) {
				unset( $data['fields']['fixVersions'] );
			}
			if( !$jiraIssueStart ) {
				unset( $data['fields']['customfield_'.$jiraStartCfId] );
			}
			if( !$jiraIssueEnd ) {
				unset( $data['fields']['customfield_'.$jiraEndCfId] );
			}
//			if( !$jiraIssueRemainingEstimate && !$jiraIssueOriginalEstimate ) {
//				unset( $data['fields']['timetracking'] );
//			}
//			elseif( !$jiraIssueRemainingEstimate ) {
//				unset( $data['fields']['timetracking']['remainingEstimate'] );
//			}
//			elseif( !$jiraIssueOriginalEstimate ) {
//				unset( $data['fields']['timetracking']['originalEstimate'] );
//			}

			jira_request( 'issue', 'POST', $data );
			$jiraRecipIssueId = $requestResult['id'];
			$jiraRecipIssueKey = $requestResult['key'];

			// Create attachment and attach it to created issue
			if( isset( $jiraIssueAttachments ) ) {
				foreach( $jiraIssueAttachments as $jiraIssueAttachment ) {
					// Download Attachment from jira-initiator issue
					jira_connect( $jiraInitDomain );
					$jiraAttachmentFile = $jiraCloneIssueAttachmentsDir . $jiraIssueAttachment['filename'];
					$jiraAttachmentUrl = $jiraIssueAttachment['content'];
					$downloadableFile = fopen($jiraAttachmentFile, 'w');
					jira_request( 'attachment' );
					fclose( $downloadableFile );

					// Post Downloaded Attachment to jira-recipient issue
					jira_connect( $jiraRecipDomain );
					$data = [
						'file' => curl_file_create( $jiraAttachmentFile )
					];
					$jiraIssueId = $jiraRecipIssueId;
					jira_request( 'attachment', 'POST', $data );

					unlink( $jiraAttachmentFile );

					// Push jira-recipient attachment id to file. (In the full version, ID matches are not configured through file data)
					$jiraInitAttachmentId = $jiraIssueAttachment['id'];
					$jiraRecipAttachmentId = $requestResult[0]['id'];
					file_put_contents( $jiraCloneIssueAttachmentsDir . $jiraRecipAttachmentId . '_' . $jiraInitAttachmentId . '_' . $jiraRecipIssueId . '_' . $jiraInitIssueId, '' );
				}
			}

			// Post jira-recipient issue key to jira-initiator issue
			jira_connect( $jiraInitDomain );
			$data = array(
				'fields' => array(
					'customfield_'.$jiraIssueExternalKeyCfId => $jiraRecipIssueKey
				)
			);
			$jiraIssueId = $jiraInitIssueId;
			jira_request( 'issue', 'PUT', $data );

			// Create comment to jira-recipient issue
			if( isset( $jiraIssueComment ) ) {
//				jira_connect( $jiraInitDomain );
				unset( $jiraRecipIssueId );
				include JIRA_INC . 'jira-comment-create.php';
			}
?>
