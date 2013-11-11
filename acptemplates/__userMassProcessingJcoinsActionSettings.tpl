{if $__wcf->session->getPermission('admin.jcoins.canExecuteMassProcessing')}
	<div id="addJCoinsDiv">
		<fieldset>
			<legend>{lang}wcf.acp.jcoins.massprocessing.general{/lang}</legend>

			<dl>
				<dt><label>{lang}wcf.acp.jcoins.massprocessing.fromuser{/lang}</label></dt>
				<dd>
					<label><input type="radio" name="fromUser" value="0" {if $fromUser == '0'}checked="checked" {/if}/> {lang}wcf.acp.jcoins.massprocessing.fromuser.system{/lang}</label>
					<label><input type="radio" name="fromUser" value="own" {if $fromUser != '0'}checked="checked" {/if}/> {lang}wcf.acp.jcoins.massprocessing.fromuser.own{/lang}</label>
				</dd>
			</dl>

			<dl>
				<dt><label for="sum">{lang}wcf.acp.jcoins.jcoins{/lang}</label></dt>
				<dd>
					<input type="integer" id="sum" name="sum" value="{$sum}" class="medium" />
				</dd>
			</dl>

			<dl{if $errorField == 'reason'} class="formError"{/if}>
				<dt><label for="reason">{lang}wcf.acp.jcoins.reason{/lang}</label></dt>
				<dd>
					<input type="text" id="reason" name="reason" value="{$reason}" class="medium" />
					{if $errorField == 'reason'}
						<small class="innerError">
							{lang}wcf.global.form.error.empty{/lang}
						</small>
					{/if}
				</dd>
			</dl>
		</fieldset>
	</div>
{/if}