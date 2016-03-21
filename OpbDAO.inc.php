<?php

/**
 *
 * Plugin for submitting an article from OSF.io
 * Written by Andy Byers, Ubiquity Press
 *
 */

class OpbDAO extends DAO {

	function getInsertClaimId() {
		return $this->getInsertId('article_opb_badges', 'badge_award_id');
	}

	function save_claim($params) {
		var_dump($params);
		echo "<br /><br />";
		$sql = <<< EOF
			INSERT INTO article_opb_badges
			(article_id, open_data, open_data_url, open_data_explaination, open_materials, open_materials_url, open_materials_explaination, pre_reg, pre_reg_url, pre_reg_registered, pre_reg_additional, pre_reg_changes, pre_reg_description)
			VALUES
			(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
EOF;
		$commit = $this->update($sql, $params);
		$claim_id = $this->getInsertClaimId();
		return $claim_id;
	}
	
	function get_claimed_badges($article_id) {
		$sql = <<< EOF
			SELECT * FROM article_opb_badges
			WHERE article_id = ?
EOF;
		return $this->retrieve($sql, array($article_id));
	}

	function get_claim_review($article_id) {
		$sql = <<< EOF
			SELECT * FROM article_opb_review_claims
			WHERE article_id = ?
EOF;
		return $this->retrieve($sql, array($article_id));
	}

	function save_claim_review($params) {
		$sql = <<< EOF
			INSERT INTO article_opb_review_claims
			(badge_award_id, article_id, reviewer_id, open_data, open_materials, pre_reg)
			VALUES
			(?, ?, ?, ?, ?, ?)
EOF;
		$commit = $this->update($sql, $params);
	}
}

