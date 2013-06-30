{if $transferID|isset}
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.ACP.Worker('mail', 'wcf\\system\\worker\\TransferWorker', '', {
				transferID: {@$transferID}
			});
		});
		//]]>
	</script>
{/if}