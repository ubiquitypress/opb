{assign var="pageTitleTranslated" value=$page_title}
{include file="common/header.tpl"}

{literal}
<style>
	img {
		width: 80px;
		margin: 10px;
	}
</style>
{/literal}
<form method="GET" action="claim/">
	<input type="hidden" name="article_id" value="{$article->getId()}">
	<h2>About Open Practice Badges</h2>
	<p>Openness is a core value of scientific practice. There is no central authority determining the validity of scientific claims. Accumulation of scientific knowledge proceeds via open communication with the community. Sharing evidence for scientific claims facilitates critique, extension, and application. Despite the importance of open communication for scientific progress, present norms do not provide strong incentives for individual researchers to share data, materials, or their research process.</p>
	<h2>The Badges</h2>
	<img align="right" src="{$static}img/open_data_grey_big.png" class"image" />
	<p>The <strong>Open Data</strong> badge is earned for making publicly available the digitally-shareable data necessary to reproduce the reported results. Criteria:</p>
	<ol>
		<li>
			Digitally-shareable data are publicly available on an open-access repository (e.g., university repository or one at www.re3data.org or www.databib.org)
		</li>
		<li>
			A codebook is included with sufficient description for an independent researcher to reproduce the reported analyses and results. Data from the same project that are not needed to reproduce the reported results can be kept private without losing eligibility for the Open Data badge.
		</li>
	</ol>
	<input type="checkbox" value="1" name="opendata" id="opendata"><label for="opendata"><strong>I'd like to claim this badge</strong></label>
	<br />
	<div class="separator"></div>
	<img align="right" src="{$static}img/open_materials_grey_big.png" class"image" />
	<p>The <strong>Open Materials</strong> badge is earned by making publicly available the components of the research methodology needed to reproduce the reported procedure and analysis.  Criteria:</p>
	<ol>
		<li>Digitally-shareable materials are publicly available on an open-access repository</li>
		<li>Infrastructure, equipment, biological materials, or other components that cannot be shared digitally are described in sufficient detail for an independent researcher to understand how to reproduce the procedure</li>
		<li>Sufficient explanation for an independent researcher to understand how the materials relate to the reported methodology</li>
	</ol>
	<input type="checkbox" value="2" name="openmaterials" id="openmaterials"><label for="openmaterials"><strong>I'd like to claim this badge</strong></label>
	<div class="separator"></div>
	<img align="right" src="{$static}img/prereg_grey_big.png" class"image" />
	<p><strong>The Preregistered+Analysis Plan</strong> badge is earned for having a preregistered research design (described above) and an analysis plan for the research and reporting results according to that plan. An analysis plan includes specification of the variables and the analyses that will be conducted. Guidance on construction of an analysis plan is below.  </p>
	<p>Criteria for earning the preregistered+analysis plan badge on a report of research are:  </p>
	
	<ol>
	<li>A public date-time stamped registration is in an institutional registration system (e.g., <a href="http://ClinicalTrials.gov" rel="nofollow">ClinicalTrials.gov</a>, Open Science Framework, AEA registry, EGAP).</li><img align="right" src="{$static}img/pre_reg_plus_grey_big.png" class"image" />
	<li>Registration pre-dates the intervention</li>
	<li>Registered design and analysis plan corresponds directly to reported design and analysis</li>
	<li>Full disclosure of results in accordance with the registered plan  </li>
	</ol>
	<p>Notations may be added to badges.  Notations qualify badge meaning: 
	TC, or Transparent Changes, means that the design or analysis plan was altered but the changes are described and a rationale for the changes are provided. Where possible analyses following the original specification should also be provided.
	DE, or Data Exist, means that (2) is replaced with “registration postdates realization of the outcomes, but the authors have yet to inspect or analyze the outcomes.”</p>
	<input type="checkbox" value="3" name="openprereg" id="openprereg"><label for="openprereg"><strong>I'd like to claim this badge</strong></label>
	<p><strong><em>Guidance on Analysis Plans</em></strong></p>
	<p><em>Procedures</em></p>
	<ul>
	<li>What is your planned sample size?</li>
	<li>If applicable, how many individual units and how many clusters?</li>
	<li>If you are conducting a randomized control trial or experimental study, how will you randomize?</li>
	<li>At what level will you randomize (individual or cluster level)</li>
	</ul>
	<p><em>Exclusions</em>
	 - What conditions will lead to data being excluded?</p>
	<p><em>Variable Construction</em></p>
	<ul>
	<li>If your predictor variable(s) are not from a single question or measure, how will they be constructed?</li>
	<li>If your outcome variable(s) are not from a single question or measure, how will they be constructed?</li>
	</ul>
	<p><em>Tests or models</em></p>
	<ul>
	<li>What is the quantity you intend to estimate?</li>
	<li>What is the unit of analysis (if applicable)?</li>
	<li>What statistical model(s) will you use to test your hypothesis? Please include the type of model (e.g. ANOVA, regression, SEM, etc) and well as the specification of the model (e.g. what variables will be included and how they will be included)</li>
	<li>If you are comparing multiple conditions or testing multiple outcomes and/or hypotheses, how will you account for this?</li>
	</ul>
	<p>In addition, the researcher will be invited to pre-specify procedures that will be used in the event of foreseeable problems  (E.g., attrition, noncompliance, failure to enroll the planned number of subjects, etc.) that routinely afflict certain kinds of studies.</p>
	<div class="separator"></div><br />
	<button type="submit" class="button-secondary">Start Claim Process</button>
</form>


{include file="common/footer.tpl"}