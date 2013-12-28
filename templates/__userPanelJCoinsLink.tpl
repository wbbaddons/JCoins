{if MODULE_JCOINS && $__wcf->user->userID}
	<li id="jCoinsUserPanelLink" class="dropdown">
		<a class="dropdownToggle" data-toggle="userMenu" href="{link controller='OwnCoinsStatement'}{/link}">
			<span class="icon icon16 icon-money"></span>
			<span>{lang}wcf.jcoins.title{/lang}</span> <span class="badge badgeInverse">{#$__wcf->user->jCoinsBalance}</span>
		</a>

		<ul class="dropdownMenu">
			<li><a href="{link controller='OwnCoinsStatement'}{/link}">{lang}wcf.jcoins.statement.title{/lang}</a></li>
		{if MODULE_JCOINS_PREMIUMGROUPS && $premiumGroupsAvailable|isset && $premiumGroupsAvailable}
			<li><a href="{link controller='JCoinsPremiumGroupsOverview'}{/link}">{lang}wcf.jcoins.premiumgroups.link{/lang}</a></li>
		{/if}

		{event name='additionalJCoinsLinks'}

		{hascontent}
		<li class="dropdownDivider"></li>

		{content}
		{if $__wcf->session->getPermission('mod.jcoins.canSeeTransferList')}
			<li><a href="{link controller='JCoinsGlobalActivity'}{/link}">{lang}wcf.jcoins.statement.globalactivity{/lang}</a></li>
			{/if}

		{event name='additionalJCoinsModLinks'}
		{/content}
		{/hascontent}
	</ul>
</li>
{/if}
