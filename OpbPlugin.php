<?php

/**
 *
 * Plugin for submitting an article from Opb.io
 * Written by Andy Byers, Ubiquity Press
 *
 */

import('lib.pkp.classes.plugins.GenericPlugin');
require_once('OpbDAO.inc.php');

class OpbPlugin extends GenericPlugin {
	function register($category, $path) {
		if (parent::register($category, $path)) {
			if ($this->getEnabled()) {
				HookRegistry::register("LoadHandler", array(&$this, "handleRequest"));
				$tm =& TemplateManager::getManager();
				$tm->assign("OpbEnabled", true);
				define('Opb_PLUGIN_NAME', $this->getName());
			}
			return true;
		}
		return false;
	}


	function handleRequest($hookName, $args) {
		$page =& $args[0];
		$op =& $args[1];
		$sourceFile =& $args[2];

		if ($page == 'opb') {
			$this->import('OpbHandler');
			Registry::set('plugin', $this);
			define('HANDLER_CLASS', 'OpbHandler');
			return true;
		}
		return false;
	}

	function getName() {
		return "OPB";
	}

	function getDisplayName() {
		return "Open Practice Badges";
	}
	
	function getDescription() {
		return "Allows Opb users to submit articles directly to OJS.";
	}
	
	function getTemplatePath() {
		return parent::getTemplatePath() . 'templates/';
	}


	function getStaticPath() {
		return '/' . parent::getPluginPath() . '/templates/static/';
	}

}
