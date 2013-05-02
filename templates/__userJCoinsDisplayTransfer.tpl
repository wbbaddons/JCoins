{if MODULE_JCOINS}
    <script src="./wcf/js/WCF.JCoins.js"></script>
{if $user->userID != $__wcf->user->userID}<li id="transferButton">
    <a class="button jsTooltip" href="{link controller='JCoinsTransfer' object=$user}{/link}" title="{lang}wcf.jCoins.transfer.info{/lang}">
	<span>{lang}wcf.jCoins.transfer{/lang}</span>
    </a>
</li>{/if}{/if}