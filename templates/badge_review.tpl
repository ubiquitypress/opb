<div class="separator"></div>
<h2>Open Practice Badges</h2>
{if !$previous_review}
<p>A review for Open Practice Badges has been requested</p>
<ol><li><a target="_blank" href="{$currentJournal->getUrl()}/opb/peer_review/?article_id={$article->getId()}">Review Open Practice Badges</a></li></ol>
{else}
<p>Review has been completed already</p>
{/if}