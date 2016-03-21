{assign var="pageTitleTranslated" value=$page_title}
{include file="common/header.tpl"}

{literal}
<style>
	img {
		width: 80px;
		margin: 10px;
	}

	.perm {
		width: 300px;
	}
</style>
{/literal}

<h2>Making Claim for {$article->getLocalizedTitle()}</h2>

{if $errors}
<div style="width: 100%; color: #a94442; background-color: #f2dede; padding: 5px; margin-bottom: 10px;">
	<p>There are some errors on the form:</p>
	<ul>
		{foreach item=item key=key from=$errors}
		<li>{$key} {$item}</li>
		{/foreach}
	</ul>
</div>
{/if}

<form method="POST">
	<input type="hidden" name="article_id" value="{$article->getId()}">
	{if $claims.opendata}
	<img align="right" src="{$static}img/open_data_grey_big.png" class"image" /><h2>Open Data Badge</h2>
	<label for="perm-opendata">Provide the URL, doi, or other permanent path for accessing the data in a public, open-access repository:</label>
	<br /><br />
	<input type="text" class="perm" name="badge[opendata][doi]" id="perm-1" placeholder="DOI / Link" {if $post}value="{$post.badge.opendata.doi}"{/if}/>
	<br /><br />
	<label for="opendata-confirm">Confirm that there is sufficient information for an independent researcher to reproduce all of the reported results, including codebook if relevant: </label><br />
	<input type="checkbox" id="opendata-confirm" name="badge[opendata][confirm]" value="confirm-1" {if $post.badge.opendata.confirm}checked="checked"{/if} /><br /><br />
	<label for="explain-1">Otherwise, explain below:</label><br />
	<br />
	<textarea cols="100" rows="5" id="explain-1" name="badge[opendata][explain]" placeholder="Explain here if there is not sufficient information at your link.">{if $post}{$post.badge.opendata.explain}{/if}</textarea>
	
	<div class="separator"></div>
	{/if}
	{if $claims.openmaterials}
	<img align="right" src="{$static}img/open_materials_grey_big.png" class"image" /><h2>Open Materials Badge</h2>
	<label for="perm-opendata">Provide the URL, doi, or other permanent path for accessing the data in a public, open-access repository:</label>
	<br /><br />
	<input type="text" class="perm" name="badge[openmaterials][doi]" id="perm-2" placeholder="DOI / Link" {if $post}value="{$post.badge.openmaterials.doi}"{/if} />
	<br /><br />
	<label for="openmaterials-confirm">Confirm that there is sufficient information for an independent researcher to reproduce all of the reported methodology: </label><br />
	<input type="checkbox" id="openmaterials-confirm" name="badge[openmaterials][confirm]" value="confirm-1" {if $post.badge.openmaterials.confirm}checked="checked"{/if} /><br /><br />
	<label for="explain-2">Otherwise, explain below:</label><br />
	<br />
	<textarea cols="100" rows="5" id="explain-2" name="badge[openmaterials][explain]" placeholder="Explain here if there is not sufficient information at your link.">{if $post}{$post.badge.openmaterials.explain}{/if}</textarea>

	<div class="separator"></div>
	{/if}
	{if $claims.openprereg}
	<img align="right" src="{$static}img/prereg_grey_big.png" class"image" /><h2>Preregistered Badge</h2>
	<label for="perm-opendata">Provide the URL, doi, or other permanent path to the registration in a public, open-access repository:</label>
	<br /><br />
	<input type="text" class="perm" name="badge[openprereg][doi]" id="perm-3" placeholder="DOI / Link" {if $post}value="{$post.badge.openprereg.doi}"{/if} />
	<br /><br />
	<label for="explain-3">Was the analysis plan registered prior to examination of the data or observing the outcomes? If no, explain:</label><br />
	<br />
	<textarea cols="100" rows="5" id="explain-3" name="badge[openprereg][registered]" placeholder="Leave this blank to confirm, fill it out if not.">{if $post}{$post.badge.openprereg.registered}{/if}</textarea><img align="right" src="{$static}img/pre_reg_plus_grey_big.png" class"image" />
	<br /><br /><br />
	<label for="explain-3">Were there additional registrations for the study other than the one reported? If yes, provide links and explain:</label><br />
	<br />
	<textarea cols="100" rows="5" id="explain-3" name="badge[openprereg][additional]" placeholder="Leave this blank to confirm, fill it out if not.">{if $post}{$post.badge.openprereg.additional}{/if}</textarea>
	<br /><br /><br />
	<label for="explain-3">Were there any changes to the preregistered analysis plan for the primary confirmatory analysis? If yes, explain:</label><br />
	<br />
	<textarea cols="100" rows="5" id="explain-3" name="badge[openprereg][changes]" placeholder="Leave this blank to confirm, fill it out if not.">{if $post}{$post.badge.openprereg.changes}{/if}</textarea>
	<br /><br /><br />
	<label for="explain-3">Are all of the analyses described in the registered plan reported in the article? If no, explain:</label><br />
	<br />
	<textarea cols="100" rows="5" id="explain-3" name="badge[openprereg][description]" placeholder="Leave this blank to confirm, fill it out if not.">{if $post}{$post.badge.openprereg.description}{/if}</textarea>
	
	<div class="separator"></div><br />
	{/if}
	<button type="submit" class="button-secondary">Review Claim</button>
</form>

{literal}
<script type="text/javascript">
$(document).ready(function(){

	$('#opendata-confirm').change(function () {
	    $("#explain-1").attr('disabled', this.checked);
	    $("#explain-1").val('');
	});

	$('#openmaterials-confirm').change(function () {
	    $("#explain-2").attr('disabled', this.checked);
	    $("#explain-2").val('');
	});
});
</script>
{/literal}

{include file="common/footer.tpl"}