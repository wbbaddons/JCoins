{if $user->userID != $__wcf->user->userID && $__wcf->session->getPermission('user.jcoins.canTransfer') && MODULE_JCOINS}
	<li id="transferButton">
		<a class="button jsTooltip" href="{link controller='JCoinsTransfer' object=$user}{/link}" title="{lang}wcf.jcoins.transfer.info{/lang}">
			<span>{lang}wcf.jcoins.transfer{/lang}</span>
		</a>
	</li>
{/if}