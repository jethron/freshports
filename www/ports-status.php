<?php
	#
	# $Id: ports-broken.php,v 1.2 2006-12-17 12:06:14 dan Exp $
	#
	# Copyright (c) 1998-2004 DVL Software Limited
	#

	require_once($_SERVER['DOCUMENT_ROOT'] . '/../include/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../include/freshports.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../include/databaselogin.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../include/getvalues.php');

	require_once($_SERVER['DOCUMENT_ROOT'] . '/../include/freshports_page_list_ports.php');

	# not using this yet, but putting it in here.	
	if (IsSet($_REQUEST['branch'])) {
		$Branch = htmlspecialchars($_REQUEST['branch']);
	} else {
		$Branch = BRANCH_HEAD;
	}

	if (IsSet($_REQUEST['status'])) {
		$Status = strtolower($_REQUEST['status']);
	} else {
		$Status = 'new';
	}

	$attributes = array('branch' => $Branch);

	$page = new freshports_page_list_ports($attributes);

	$page->setDebug(0);

	$page->setDB($db);

	switch ($Status) {
	case 'broken':
		$page->setTitle('Broken ports');
		$page->setDescription('These are the broken ports');
		$page->setSQL("ports.broken <> ''", $User->id);
		break;
	case 'deleted':
		$page->setTitle('Deleted ports');
		$page->setDescription('These are the deleted ports');
		$page->setStatus('D');
		$page->setSQL('', $User->id);
		break;
	case 'deprecated':
		$page->setTitle('Deprecated ports');
		$page->setDescription('These are the deprecated ports');
		$page->setSQL("ports.deprecated <> ''", $User->id);
		break;
	case 'expiration-date':
		$page->setTitle('Ports with an expiration date');
		$page->setDescription('These ports have an expiration date, after which they may be removed from the tree');
		$page->setSQL("ports.expiration_date is not null", $User->id);
		break;
	case 'expired':
		$page->setTitle('Ports that have expired');
		$page->setDescription('These ports are past their expiration date.  This list never includes deleted ports.');
		$page->setSQL("ports.expiration_date IS NOT NULL AND CURRENT_DATE > ports.expiration_date", $User->id);
		break;
	case 'forbidden':
		$page->setTitle('Forbidden ports');
		$page->setDescription('These are the forbidden ports');
		$page->setSQL("ports.forbidden <> ''", $User->id);
		break;
	case 'ignore':
		$page->setTitle('Ignored ports');
		$page->setDescription('These are the ignored ports');
		$page->setSQL("ports.ignore <> ''", $User->id);
		break;
	case 'interactive':
		$page->setTitle('Interactive ports');
		$page->setDescription('These are the interactive ports');
		$page->setSQL("ports.is_interactive <> ''", $User->id);
		break;
	case 'no-cdrom':
		$page->setTitle('NO CDROM ports');
		$page->setDescription('These are the NO CDROM ports');
		$page->setSQL("ports.no_cdrom <> ''", $User->id);
		break;
	case 'restricted':
		$page->setTitle('Restricted ports');
		$page->setDescription('These are the restricted ports');
		$page->setSQL("ports.restricted <> ''", $User->id);
		break;
	case 'vulnerable':
		$page->setTitle('Vulnerable ports');
		$page->setDescription('These are the vulnerable ports');
		$page->setSQL("PV.current != 0", $User->id);
		break;
	}

	$page->display();
