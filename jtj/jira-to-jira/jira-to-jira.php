<?php
/*
Module Name: Jira to Jira Integration Module
Module URL: https://github.com/DTs-dev/jira-to-jira
Description: Integration module for interaction between two Jira instances
Author: Dmitriy Tsyganok
Author URL: https://github.com/DTs-dev
License: GPL v3
*/

// Main paths
define('MODULE_DIR', __DIR__ . '/');
define('LOG_DIR', MODULE_DIR . 'logs/');
define('INCLUDES', MODULE_DIR . 'includes/');
define('JIRA_DIR', INCLUDES . 'jira/');
define('COMP_INC', 'inc/');

define('JIRA_INC', JIRA_DIR . COMP_INC);

// Jira Transfer Component for JTJ module
include_once JIRA_DIR . 'jira.php';
?>
