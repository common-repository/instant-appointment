<div>
   <tr class="form-field">
		<th><label for="insapp_text">Text Field</label></th>
		<td>
			<input name="insapp_text" id="insapp_text" type="text" value="<?php echo esc_attr( $text_field ) ?>" />
			<p class="description">Field description may go here.</p>
		</td>
	</tr>
	<tr class="form-field">
		<th>
			<label for="insapp_img">Image Field</label>
		</th>
		<td>
			<?php if( $image = wp_get_attachment_image_url( $image, 'medium' ) ) : ?>
				<a href="#" class="insapp-upload">
					<img src="<?php echo esc_url( $image ) ?>" />
				</a>
				<a href="#" class="insapp-remove">Remove image</a>
				<input type="hidden" name="insapp_img" value="<?php echo absint( $image_id ) ?>">
			<?php else : ?>
				<a href="#" class="button insapp-upload">Upload image</a>
				<a href="#" class="insapp-remove" style="display:none">Remove image</a>
				<input type="hidden" name="insapp_img" value="">
			<?php endif; ?>
		</td>
	</tr>
</div>