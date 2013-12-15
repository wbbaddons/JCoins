{if $transferID|isset}
	<script data-relocate="true" type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.ACP.Worker('transfer', 'wcf\\system\\worker\\TransferWorker', '', {
				transferID: {@$transferID}
			});
		});
		//]]>
	</script>
{/if}