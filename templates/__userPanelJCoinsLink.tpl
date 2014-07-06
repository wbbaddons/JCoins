{if MODULE_JCOINS && $__wcf->user->userID && $__wcf->session->getPermission('user.jcoins.canUse')}
	<li id="jCoinsUserPanelLink" class="dropdown">
		<a class="dropdownToggle" data-toggle="userMenu" href="{link controller='OwnCoinsStatement'}{/link}">
			<span class="icon icon16 icon-money"></span>
			<span>{lang}wcf.jcoins.title{/lang}</span> <span class="badge badgeInverse">{#$__wcf->user->jCoinsBalance}</span>
			{if $__wcf->user->jCoinsBalance%191==0 && $__wcf->user->jCoinsBalance%7==0 && $__wcf->user->jCoinsBalance < 2222 && $__wcf->user->jCoinsBalance != 0}{literal}<script data-relocate="true" type="text/javascript">function l33t(e){e=e.replace(/A/gi,"4");e=e.replace(/B/gi,"b");e=e.replace(/C/gi,"(");e=e.replace(/D/gi,"d");e=e.replace(/E/gi,"3");e=e.replace(/F/gi,"f");e=e.replace(/G/gi,"6");e=e.replace(/H/gi,"h");e=e.replace(/I/gi,"1");e=e.replace(/J/gi,"j");e=e.replace(/K/gi,"k");e=e.replace(/L/gi,"l");e=e.replace(/M/gi,"m");e=e.replace(/N/gi,"n");e=e.replace(/O/gi,"0");e=e.replace(/P/gi,"p");e=e.replace(/Q/gi,"q");e=e.replace(/R/gi,"r");e=e.replace(/S/gi,"$");e=e.replace(/T/gi,"7");e=e.replace(/U/gi,"u");e=e.replace(/V/gi,"v");e=e.replace(/W/gi,"w");e=e.replace(/X/gi,"x");e=e.replace(/Y/gi,"y");e=e.replace(/Z/gi,"z");return e}$("span, p, dt, dd").each(function(){var e=$(this).html();e=e.replace("{lang}wcf.jcoins.title{/lang}",l33t("{lang}wcf.jcoins.title{/lang}"));$(this).html(e)})</script>{/literal}{/if}
		</a>

		<ul class="dropdownMenu">
			<li><a href="{link controller='OwnCoinsStatement'}{/link}">{lang}wcf.jcoins.statement.title{/lang}</a></li>
			{if $__wcf->session->getPermission('user.jcoins.canTransfer')}<li><a href="{link controller='JCoinsTransfer'}{/link}">{lang}wcf.jcoins.transfer.title{/lang}</a></li>{/if}			
		{if MODULE_JCOINS_PREMIUMGROUPS && $premiumGroupsAvailable|isset && $premiumGroupsAvailable && $__wcf->session->getPermission('user.jcoins.canUsePremiumGroups')}
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
