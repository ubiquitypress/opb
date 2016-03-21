<?php

/**
 *
 * Plugin for submitting an article from Opb.io
 * Written by Andy Byers, Ubiquity Press
 *
 */

import('classes.handler.Handler');
require_once('classes/security/Validation.inc.php');
require_once('OpbDAO.inc.php');



function redirect($url) {
	header("Location: ". $url); // http://www.example.com/"); /* Redirect browser */
	/* Make sure that code below does not get executed when we redirect. */
	exit;
}

function raise404($msg='404 Not Found') {
	header("HTTP/1.0 404 Not Found");
	fatalError($msg);
	return;
}

function clean_string($v) {
	// strips non-alpha-numeric characters from $v	
	return preg_replace('/[^\-a-zA-Z0-9]+/', '',$v);
}

class OpbHandler extends Handler {

	public $dao = null;

	function OpbHandler() {
		parent::Handler();
		$this->dao = new OpbDAO();
	}
	
	// utils

	/* sets up the template to be rendered */
	function display($fname, $page_context=array()) {
		// setup template
		AppLocale::requireComponents(LOCALE_COMPONENT_OJS_MANAGER, LOCALE_COMPONENT_PKP_MANAGER);
		parent::setupTemplate();
		
		// setup template manager
		$templateMgr =& TemplateManager::getManager();
		
		// default page values
		$context = array(
			"page_title" => "Open Practice Badges Claim"
		);
		foreach($page_context as $key => $val) {
			$context[$key] = $val;
		}

		$plugin =& PluginRegistry::getPlugin('generic', Opb_PLUGIN_NAME);
		$tp = $plugin->getTemplatePath();
		$context["template_path"] = $tp;
		$context["static"] = $plugin->getStaticPath();
		$context["article_select_template"] = $tp . "article_select_snippet.tpl";
		$context["article_pagination_template"] = $tp . "article_pagination_snippet.tpl";
		$context["disableBreadCrumbs"] = true;
		$templateMgr->assign($context); // http://www.smarty.net/docsv2/en/api.assign.tpl

		// render the page
		$templateMgr->display($tp . $fname);
	}

	function claim_keys() {
		return array('opendata', 'openmaterials', 'openprereg');
	}

	function login_required($request) {
		$user =& $request->getUser();
		$journal =& $request->getJournal();
		if ($user == NULL){
			redirect($journal->getUrl() . '/login/signIn?source=' . $_SERVER['REQUEST_URI']); 
		} else {
			return True;
		}
	}

	function check_and_get_article($request) {
		$article_id = $request->_requestVars['article_id'];
		$user = $request->getUser();

		if (!$article_id){
			raise404();
		}

		$articleDao =& DAORegistry::getDAO('ArticleDAO');
		$article =& $articleDao->getArticle($article_id);

		if (!$article || $article->getUserId() != $user->getId()){
			raise404("You are not the owner of this article.");
		}

		return $article;
	}

	function reviewer_check_and_get_article($request) {
		$article_id = $request->_requestVars['article_id'];
		$user = $request->getUser();

		if (!$article_id){
			raise404("Article ID not found");
		}

		$articleDao =& DAORegistry::getDAO('ArticleDAO');
		$article =& $articleDao->getArticle($article_id);

		$reviewAssignmentDao =& DAORegistry::getDAO('ReviewAssignmentDAO');
		$review_assignment = $reviewAssignmentDao->getReviewAssignment(
			$article->getId(), 
			$user->getId(), 
			$article->getCurrentRound()
		);

		if (!$review_assignment){
			raise404("You are not a reviewer for this article.");
		} elseif ($review_assignment && $review_assignment->getDateCompleted()) {
			raise404("You have already completed your review of this article");
		} elseif ($review_assignment && !$review_assignment->getDateConfirmed()) {
			raise404("You have not confirmed that you will review this article.");
		}

		$previous_review = $this->dao->get_claim_review($article->getId());
		if ($previous_review->fields) {
			raise404("This claim has already been reviewed.");
		}

		return $article;
	}

	function handle_claims($get) {
		foreach ($get as $key => $var) {
			if ($key == "article_id" || !in_array($key, $this->claim_keys())) {
				unset($get[$key]);
			} 
		}
		return $get;
	}

	function handle_claim_post($post, $claims) {
		$errors = array();

		foreach ($claims as $badge => $val) {
			$current = $post['badge'][$badge];
			if (!$current['doi']) {
				$errors[$badge] = "DOI/Permanent URL is required";
			} elseif (filter_var($current['doi'], FILTER_VALIDATE_URL) === FALSE) {
				$errors[$badge] = "A valid URL is required.";
			}
		}

		return $errors;
	}

	function generate_claim_params($post, $claims) {
		$params = array();
		$params["article_id"] = $post["article_id"];

		var_dump($claims);

		foreach ($claims as $badge => $val) {
			$current = $post['badge'][$badge];
			echo $badge;
			if ($badge == "opendata") {
				$params["open_data"] = 1;
				$params["open_data_url"] = $current["doi"];
				$params["open_data_explaination"] = $current["explain"];
			} 

			if ($badge == "openmaterials") {
				$params["open_materials"] = 1;
				$params["open_materials_url"] = $current["doi"];
				$params["open_materials_explaination"] = $current["explain"];
			}

			if ($badge == "openprereg") {
				$params["pre_reg"] = 1;
				$params["pre_reg_url"] = $current["doi"];
				$params["pre_reg_registered"] = $current["registered"];
				$params["pre_reg_additional"] = $current["additional"];
				$params["pre_reg_changes"] =$current["changes"];
				$params["pre_reg_description"] =  $current["description"];
			} 

		}
		if (!in_array("opendata", $claims)) {
				$params["open_data"] = NULL;
				$params["open_data_url"] = NULL;
				$params["open_data_explaination"] = NULL;
		}

		if (!in_array("openmaterials", $claims)) {
				$params["open_materials"] = 1;
				$params["open_materials_url"] = $current["doi"];
				$params["open_materials_explaination"] = $current["explain"];
		}

		if (!in_array("openprereg", $claims)) {
				$params["pre_reg"] = NULL;
				$params["pre_reg_url"] = NULL;
				$params["pre_reg_registered"] = NULL;
				$params["pre_reg_additional"] = NULL;
				$params["pre_reg_changes"] = NULL;
				$params["pre_reg_description"] =  NULL;
		}
		
		return $params;
	}

	//
	// views
	//
	
	/* handles requests to:
		/opb/
		/opb/index/
	*/
	function index($args, &$request) {
		$this->login_required($request);
		$article = $this->check_and_get_article($request);

		$context = array(
			"article" => $article,
		);
		$this->display('index.tpl', $context);
	}

	/* handles requests to:
		/opb/claim/
	*/
	function claim($args, &$request) {
		$this->login_required($request);
		$article = $this->check_and_get_article($request);
		$claims = $this->handle_claims($_GET);

		if ($this->dao->get_claimed_badges($article->getId())->fields) {
			raise404("This article already has a badge claim.");
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = $this->handle_claim_post($_POST, $claims);

			if (empty($errors)) {
				$this->dao->save_claim(
					$this->generate_claim_params($_POST, $_GET)
				);
				redirect($request->getJournal()->getUrl() . "/opb/review/?article_id=" . $article->getId());
			}
		}

		$context = array(
			"claims" => $claims,
			"article" => $article,
			"errors" => $errors,
			"post" => $_POST,
		);
		$this->display('claim.tpl', $context);

	}

	/* handles requests to:
		/opb/claim/review/
	*/
	function review($args, &$request) {
		$this->login_required($request);
		$article = $this->check_and_get_article($request);

		$claimed_badges = $this->dao->get_claimed_badges($article->getId());

		$context = array(
			"article" => $article,
			"claims" => $claimed_badges->fields,
			"page_title" => "OPB Review"
		);
		$this->display('review.tpl', $context);
	}

	/* handles requests to:
		/opb/claim/review/
	*/
	function peer_review($args, &$request) {
		$this->login_required($request);
		$article = $this->reviewer_check_and_get_article($request);

		$claimed_badges = $this->dao->get_claimed_badges($article->getId());

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$params = array(
				"badge_award_id" => $claimed_badges->fields["badge_award_id"],
				"article_id" => $article->getId(),
				"reviewer_id" => $request->getUser()->getId(),
				"open_data" => ($_POST["open_data"] ? 1:0),
				"open_materials" => ($_POST["open_materials"] ? 1:0),
				"pre_reg" => ($_POST["pre_reg"] ? 1:0),
			);

			$this->dao->save_claim_review($params);
			redirect($request->getJournal()->getUrl() . "/opb/thanks/");

		}

		$context = array(
			"article" => $article,
			"claims" => $claimed_badges->fields,
			"page_title" => "OPB Peer Review"
		);
		$this->display('peer_review.tpl', $context);
	}

	function thanks($args, &$request) {
		$this->login_required($request);

		$context = array();
		$this->display('thanks.tpl', $context);
	}
}

?>