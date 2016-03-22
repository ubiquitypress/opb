<div class="separator"></div>
<h3>Open Pracice Badges Claimed</h3>
{if $claims.open_data}
	<h2>Open Data Badge</h2>
	Provided URL / DOI: <a target="_blank" href="{$claims.open_data_url}">{$claims.open_data_url}</a>
{/if}

{if $claims.open_materials}
	<h2>Open Materials Badge</h2>
	Provided URL / DOI: <a target="_blank" href="{$claims.open_materials_url}">{$claims.open_materials_url}</a>
{/if}

{if $claims.pre_reg}
	<h2>Preregistration Badge</h2>
	Provided URL / DOI: <a target="_blank" href="{$claims.pre_reg_url}">{$claims.pre_reg_url}</a>
{/if}