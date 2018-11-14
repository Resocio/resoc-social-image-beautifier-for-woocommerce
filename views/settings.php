<div class="wrap">
	<?php screen_icon() ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<form action="<?php echo $admin_url ?>" method="post" id="rsibfwc-settings-form">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">Merchant Id</th>
					<td>
            <input
              type="text"
              name="<?php echo Resoc_SIBfWC::OPTION_MERCHANT_ID ?>"
              value="<?php echo $merchant_id ?>"
            />
					</td>
				</tr>
			</tbody>
		</table>

    <input type="hidden" name="<?php echo Resoc_SIBfWC::SETTINGS_FORM ?>" value="1">

		<input name="Submit" type="submit" class="button-primary" value="Save changes">
	</form>
</div>