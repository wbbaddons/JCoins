{if MODULE_JCOINS && $__wcf->session->getPermission('user.jcoins.canSee')}
	<ul class="sidebarBoxList">
		{foreach from=$member item=member}
			<li class="box24">
				<a href="{link controller='User' object=$member}{/link}" class="framed">{@$member->getAvatar()->getImageTag(24)}</a>

				<div class="sidebarBoxHeadline">
					<h3><a href="{link controller='User' object=$member}{/link}" class="userLink" data-user-id="{@$member->userID}">{$member->username}</a></h3>
					<small>{#$member->jCoinsBalance} <span>{lang}wcf.jcoins.title{/lang}</span></small>
				</div>
			</li>
		{/foreach}
	</ul>
{/if}