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

<h2>Reviewing Claim for {$article->getLocalizedTitle()}</h2>
<p>Thanks for submitting your badge claim. A peer reviewer will look over it and confirm your claims.</p>

{if $claims.open_data}
	<h2>Open Data Badge</h2>
	Provided URL / DOI: <a target="_blank" href="{$claims.open_data_url}">{$claims.open_data_url}</a>
	{if !$claims.open_data_explaination}
	<p><strong>The author believes the URL contains enough information for an independent researcher to reproduce all of the reported results.</strong></p>
	{else}
	<p><strong>There may not be enough information at the URL for an independent researcher to reproduce all of the reported results, you have provided the following additional information:</strong></p>
	<p>{$claims.open_data_explaination|nl2br}</p>
	{/if}
{/if}

{if $claims.open_materials}
	<br />
	<div class="separator"></div>
	<br />
	<h2>Open Materials Badge</h2>
	Provided URL / DOI: <a target="_blank" href="{$claims.open_materials_url}">{$claims.open_materials_url}</a>
	{if !$claims.open_materials_explaination}
	<p>The author believes the URL contains enough information for an independent researcher to reproduce all of the reported results.</p>
	{else}
	<p><strong>There may not be enough information at the URL for an independent researcher to reproduce the reported methodology, you have provided the following additional information:</strong></p>
	<p>{$claims.open_materials_explaination|nl2br}</p>
	{/if}
{/if}

{if $claims.pre_reg}
	<br />
	<div class="separator"></div>
	<br />
	<h2>Preregistration Badge</h2>
	Provided URL / DOI: <a target="_blank" href="{$claims.pre_reg_url}">{$claims.pre_reg_url}</a>

	<p><strong>Was the analysis plan registered prior to examination of the data or observing the outcomes? If no, explain:</strong></p>
	{if !$claims.pre_reg_registered}Confirmed{else}{$claims.pre_reg_registered|nl2br}{/if}

	<p><strong>Were there additional registrations for the study other than the one reported? If yes, provide links and explain:</strong></p>
	{if !$claims.pre_reg_additional}No.{else}{$claims.pre_reg_additional|nl2br}{/if}

	<p><strong>Were there any changes to the preregistered analysis plan for the primary confirmatory analysis? If yes, explain:</strong></p>
	{if !$claims.pre_reg_changes}No.{else}{$claims.pre_reg_changes|nl2br}{/if}

	<p><strong>Are all of the analyses described in the registered plan reported in the article? If no, explain:</strong></p>
	<p>{if !$claims.pre_reg_description}Confirmed{else}{$claims.pre_reg_description|nl2br}{/if}</p>
{/if}

{include file="common/footer.tpl"}