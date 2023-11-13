<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__));
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

require_once( $_SERVER['DOCUMENT_ROOT'] . '/jira-to-jira/jira-to-jira.php' );

if( isset( $_REQUEST['user_key'] ) && function_exists('jira') ) {
	jira();
} else {
	http_response_code(404);
	echo 'Fail';
}
?>
