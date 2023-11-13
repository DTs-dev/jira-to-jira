<?php
// Jira Issue Created Default
function jira() {
	global $requestResult;
	$requestResponse = file_get_contents('php://input');
	$requestResult = json_decode($requestResponse, true);
	file_put_contents( LOG_DIR . 'jira.log', print_r( $requestResult, TRUE ) );
	include 'jira-created.php';
}
?>
