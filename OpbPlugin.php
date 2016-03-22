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
				HookRegistry::register('Templates::Author::Submit::Complete::AdditionalItems', array(&$this, 'claimLink'));
				HookRegistry::register('Templates::Author::Submission::AdditionalItems', array(&$this, 'claimedBadges'));
				HookRegistry::register('Templates::Reviewer::Submission::AdditionalItems', array(&$this, 'badgeReview'));
				HookRegistry::register('Templates::Article::MoreInfo', array(&$this, 'articleBadges'));
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

	function claimLink($hookName, $args) {
		$output =& $args[2];

		$templateMgr =& TemplateManager::getManager();
		$articleId = $templateMgr->get_template_vars('articleId');
		$currentJournal = $templateMgr->get_template_vars('currentJournal');
		$output .=  <<< EOF
		<h2>Open Practice Badges</h2>
		<p>You can claim Open Practice Badges for your article. These badges will be displayed alongside your article.</p>
		<ul><li><a target="_blank" href="{$currentJournal->getUrl()}/opb/?article_id={$articleId}">Claim Open Practice Badges</a></li></ul>
EOF;

		
		return false;
	}

	function claimedBadges($hookName, $args) {
		$output =& $args[2];
		$this->dao = new OpbDAO();

		$templateMgr =& TemplateManager::getManager();
		$article = $templateMgr->get_template_vars('submission');
		$claimed_badges = $this->dao->get_claimed_badges($article->getId());

		if ($claimed_badges->fields){
			$templateMgr->assign('claims', $claimed_badges->fields);
			$output .= $templateMgr->fetch($this->getTemplatePath() . 'author_submission.tpl');
		}
	}

	function badgeReview($hookName, $args) {
		$output =& $args[2];
		$this->dao = new OpbDAO();

		$templateMgr =& TemplateManager::getManager();
		$article = $templateMgr->get_template_vars('submission');
		$currentJournal = $templateMgr->get_template_vars('currentJournal');
		$claimed_badges = $this->dao->get_claimed_badges($article->getId());
		$previous_review = $this->dao->get_claim_review($article->getId());

		if ($claimed_badges->fields){
			$templateMgr->assign('claims', $claimed_badges->fields);
			$templateMgr->assign('article', $article);
			$templateMgr->assign('previous_review', $previous_review->fields);
			$output .= $templateMgr->fetch($this->getTemplatePath() . 'badge_review.tpl');
		}
	}

	function articleBadges($hookName, $args) {
		$output =& $args[2];
		$this->dao = new OpbDAO();

		$templateMgr =& TemplateManager::getManager();
		$article = $templateMgr->get_template_vars('article');
		$claimed_badges = $this->dao->get_claimed_badges($article->getId());
		$claim_review = $this->dao->get_claim_review($article->getId());

		if ($claimed_badges->fields){
			$templateMgr->assign('claims', $claimed_badges->fields);
			$templateMgr->assign('claim_review', $claim_review->fields);
			$templateMgr->assign('static', $this->getStaticPath());
			$output .= $templateMgr->fetch($this->getTemplatePath() . 'article_badges.tpl');
		}
	}

}
