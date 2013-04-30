{if MODULE_JCOINS}
    <script src="./wcf/js/WCF.JCoins.js"></script>
{if $user->userID != $__wcf->user->userID}<li id="transferButton">
    <a class="button jsTooltip" href="{link controller='JCoinsTransfer' object=$user}{/link}" title="jCoins an den User überweisen">
	<span>Überweisung</span>
    </a>
</li>

<script type="text/javascript">
    new WCF.JCoins.Transfer({$user->userID});
</script>{/if}{/if}