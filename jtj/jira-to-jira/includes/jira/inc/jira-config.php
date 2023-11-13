<?php
		$fileName = __FILE__;

		// JIRA CONFIGURATION
		global $fileName, $headers, $date, $jiraCommentsDir, $jiraWorklogsDir, $jiraAttachmentsDir, $jiraIssueLinksDir, $downloadableFile, $jiraJqlExtending, $jiraIssueFilterField, $jiraAttachmentDownload, $jira1Domain, $jira2Domain, $jiraUrl, $jiraProjectKey, $jiraIssueId, $jiraCommentId, $jiraWorklogId, $jiraIssueTypeId, $jiraUsername, $jiraAttachmentUrl, $jiraAttachmentId, $jiraIssueExternalIdCfId, $jiraIssueExternalKeyCfId, $jiraParentIssueType, $jiraChildIssueType, $jiraParentIssueLinkType, $jiraChildIssueLinkType, $jiraIssueSummary, $jiraReleaseCfId, $jiraStartCfId, $jiraTempoAccountCfId, $jiraEndCfId, $jiraTempoWorkAttrName, $jiraTempoWorkAttrValue, $jiraIssueLinkId;

		$jira1Domain = 'jira.example.com';
		$jira2Domain = 'jira2.company.org';

		$jiraIssueMediumPriorityName = 'Medium';
		$jiraIssueHighPriorityName = 'High';

		$jiraStoryIssueTypeName = 'Story';
		$jiraBugIssueTypeName = 'Bug';
		$jiraBugfixIssueTypeName = 'Bugfix';
		$jiraValidIssueTypes = array( $jiraBugIssueTypeName, $jiraBugfixIssueTypeName, $jiraStoryIssueTypeName );

		$jiraParentIssueType = $jiraStoryIssueTypeName;
		$jiraParentIssueLinkType = 'Parent';
		$jiraChildIssueLinkType = 'Child';

		$jiraValidIssueLinkTypes = array( 'Connection to history', 'Addiction' );

		function jira_connect( $jiraDomain ) {
			global $fileName, $jira1Domain, $jira2Domain, $jiraPrefix, $jiraUrl, $jiraUrlShema, $jiraConsumerKey, $jiraPrivateKeyFile, $jiraOauthToken, $jiraLogin, $jiraPsswd, $jiraCommentsDir, $jiraWorklogsDir, $jiraAttachmentsDir, $jiraIssueLinksDir, $jiraProjectKey, $jiraIssueExternalIdCfId, $jiraIssueExternalKeyCfId, $jiraReleaseCfId, $jiraStartCfId, $jiraEndCfId, $jiraTempoAccountCfId, $jiraTempoWorkAttrName, $jiraTempoWorkAttrValue;
			if( $jiraDomain === $jira1Domain ) {
			// Jira first domain config
				$jiraUrlShema = 'https';
				$jiraOauthToken = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'; // OAuth does not work in this demo (only in full version). Replace with "$jiraApiToken"
				$jiraConsumerKey = 'OauthKey';
				$jiraPrivateKeyFile = '/opt/www/jira_privatekey.pcks8';
				$jiraLogin = 'user';
				$jiraProjectKey = 'TEST';
				$jiraIssueExternalIdCfId = '11111';
				$jiraIssueExternalKeyCfId = '12222';
				// Extensional custom fields
				$jiraReleaseCfId = '13333';
				$jiraStartCfId = '14444';
				$jiraEndCfId = '15555';
				
				$jiraTempoAccountCfId = '16666';
				$jiraTempoWorkAttrName = false;
				$jiraTempoWorkAttrValue = false;
				// Domain additional settings
				$jiraPrefix = 'jira1';
			} elseif( $jiraDomain === $jira2Domain ) {
			// Jira second domain config
				$jiraUrlShema = 'https';
				$jiraOauthToken = false;
				$jiraApiToken = 'YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY';
				$jiraLogin = 'bot';
				$jiraProjectKey = 'DEMO';
				$jiraIssueExternalIdCfId = '22222';
				$jiraIssueExternalKeyCfId = '23333';
				// Extensional custom fields
				$jiraReleaseCfId = '24444';
				$jiraStartCfId = '25555';
				$jiraEndCfId = '26666';

				$jiraTempoAccountCfId = '27777';
				$jiraTempoWorkAttrName = 'Activity type';
				$jiraTempoWorkAttrValue = 'Work time';
				// Domain additional settings
				$jiraPrefix = 'jira2';
			}
			$jiraUrl = $jiraUrlShema . '://' . $jiraDomain;
			$jiraCommentsDir = JIRA_INC . 'comments_' . $jiraPrefix . '/';
			$jiraWorklogsDir = JIRA_INC . 'worklogs_' . $jiraPrefix . '/';
			$jiraAttachmentsDir = JIRA_INC . 'attachments_' . $jiraPrefix . '/';
			$jiraIssueLinksDir = JIRA_INC . 'issuelinks_' . $jiraPrefix . '/';

			// Check jira auth type and if it isn't oauth then jira auth by cookie
			if( empty( $jiraOauthToken ) ) {
				include JIRA_INC . 'jira-cookie-auth.php';
			}
		}

		// Include jira request function definition
		include_once JIRA_INC . 'jira-requests.php';

		// Include OAuth authorization component
		include_once JIRA_INC . 'oauth.php';

		// Include extensional functions
		include_once JIRA_INC . 'extens-functions.php';

		$jiraJqlExtending = '';

		// Jira domain-initiator identification
                $jiraInitDomain = $_REQUEST['domain'];
		if( $jiraInitDomain === $jira1Domain ) {
			$jiraRecipDomain = $jira2Domain;
		}
		elseif( $jiraInitDomain === $jira2Domain ) {
			$jiraRecipDomain = $jira1Domain;
		}
		// Jira connect to jira-initiator
		jira_connect( $jiraInitDomain );
?>
