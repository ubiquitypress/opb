{literal}
<style>
	.badge {
		width: 50px;
		margin-right: 10px;
	}
</style>
{/literal}

<div class="separator"></div>
<h3>Open Pracice Badges Awarded</h3>
{if $claim_review.open_data}
	<img align="left" class="badge" src="{$static}img/open_data_grey_big.png" class"image" />
	<h4>Open Data Badge</h4>
	
	Provided URL / DOI: <a target="_blank" href="{$claims.open_data_url}">{$claims.open_data_url}</a>
	<br /><br /><br />
{/if}

{if $claim_review.open_materials}
	<img align="left" class="badge" src="{$static}img/open_materials_grey_big.png" class"image" />
	<h4>Open Materials Badge</h4>
	Provided URL / DOI: <a target="_blank" href="{$claims.open_materials_url}">{$claims.open_materials_url}</a>
	<br /><br /><br />
{/if}

{if $claim_review.pre_reg}
	<img align="left" class="badge" src="{$static}img/prereg_grey_big.png" class"image" />
	<h4>Preregistration Badge</h4>
	Provided URL / DOI: <a target="_blank" href="{$claims.pre_reg_url}">{$claims.pre_reg_url}</a>
	<br /><br />
{/if}