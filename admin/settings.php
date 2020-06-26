<?php
/**
 * @var array $options
 * */
?>
<div class="wrap">
    <h1>Settings of WP Plugins Manager</h1>

    <form method="post" action="" name="wtbp-settings-form">
        <input type="hidden" name="wtbp-settings-update" value="update">
		<?= wp_nonce_field( 'wtbp_save_settings' ) ?>
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row"><?= __( 'Display Changelog in the update notice?', 'bulk-plugins' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?= __( 'Display Changelog in the update notice?', 'bulk-plugins' ); ?></span>
                        </legend>
                        <label>
                            <input type="radio" name="wtbp_update_changelog"
                                   value="1" <?php checked( 1, $options['update_changelog'] ); ?>>
                            <span class="date-time-text format-i18n"><?= __( 'Yes', 'bulk-plugins' ); ?></span>
                        </label>
                        &nbsp;
                        <label>
                            <input type="radio" name="wtbp_update_changelog"
                                   value="0" <?php checked( 0, $options['update_changelog'] ); ?>>
                            <span class="date-time-text format-i18n"><?= __( 'No', 'bulk-plugins' ); ?></span>
                        </label>
                    </fieldset>
                </td>
            </tr>
            </tbody>
        </table>


        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                 value="Сохранить изменения"></p></form>

</div>
