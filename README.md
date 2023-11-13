# Jira to Jira Integration Module
Integration module for interaction between two Jira instances in PHP

## Requirements
- php
- php-curl
- php-json
- php-xml
- Web-server (Nginx, Apache, etc.)

## Usage
1. Set up the configuration of jira instances in the file "jira-config.php".
2. Run the software on your web-server.
3. URL to use in webhook integration: https://your-web-server.com/jtj?domain=jira.example.com&issue_key=${issue.key} (where "jira.example.com" is the address of the JIra instance in whose webhook you enter this URL).

## Software information
This version of the module is a demo version. In this version, the functionality of creating issue, attachments and comments is available. Authorization using a personal token is also available. OAuth authorization and other full-fledged integration functionality are available in the full version.
