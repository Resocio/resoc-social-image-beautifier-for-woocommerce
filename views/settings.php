<div class="wrap">
	<?php screen_icon() ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

  <p>
    By default, Resoc Social Image Beautifier for WooCommerce crops your
    product images automatically when they are shared on social networks.
  </p>

  <p>
    By providing a <strong>Resoc Site Id</strong>, you can add your logo or name
    to the images and let your customers's friends and followers notice your brand.
  </p>

	<form action="<?php echo $admin_url ?>" method="post" id="rsibfwc-settings-form">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">Resoc Site Id</th>
					<td>
            <input
              type="text"
              name="<?php echo Resoc_SIBfWC::OPTION_RESOC_SITE_ID ?>"
              value="<?php echo $site_id ?>"
            />
					</td>
				</tr>
			</tbody>
		</table>

    <input type="hidden" name="<?php echo Resoc_SIBfWC::SETTINGS_FORM ?>" value="1">

		<input name="Submit" type="submit" class="button-primary" value="Save changes">
	</form>
</div>
