{if MODULE_JCOINS}
    {if $__wcf->user->userID != 0}
	<li id="jCoinsUserPanelLink" class="dropdown">
		<a class="dropdownToggle framed" data-toggle="userMenu" href="{link controller='OwnCoinsStatement'}{/link}"><span>{lang}wcf.jcoins.title{/lang}</span> <span class="badge badgeInverse">{#$__wcf->user->jCoinsBalance}</span></a>
		<ul class="dropdownMenu">
			<li><a href="{link controller='OwnCoinsStatement'}{/link}">{lang}wcf.jCoins.statement.title{/lang}</a></li>
			<li><a href="{link controller='JCoinsPremiumGroupsOverview'}{/link}">{lang}wcf.jCoins.premiumgroups.link{/lang}</a></li>
			{event name='additionalJCoinsLinks'}
			{hascontent}
			<li class="dropdownDivider"></li>
			    {content}
				{if $__wcf->session->getPermission('mod.jCoins.canSeeTransferList')}
				    <li><a href="{link controller='JCoinsGlobalActivity'}{/link}">{lang}wcf.jCoins.statement.globalactivity{/lang}</a></li>
				{/if}
				{event name='additionalJCoinsModLinks'}
			    {/content}
			{/hascontent}
		</ul>
	</li>	
    {/if}
{/if}