<div class="wrap">
    <h1>Настройки Bulk Plugins Manager</h1>

    <form method="post" action="" name="wtbp-settings-form">
        <input type="hidden" name="wtbp-settings-update" value="update">
        <input type="hidden" id="_wpnonce" name="_wpnonce" value="">
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row">Формат работы плагина</th>
                <td>
                    <fieldset><legend class="screen-reader-text"><span>Формат работы плагина</span></legend>
                        <label>
                            <input type="radio" name="wtbp_work_format" value="1" checked="checked">
                            <span class="date-time-text format-i18n">Добавлять отдельную ссылку <b>"Деактивировать и удалить"</b></span>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="wtbp_work_format" value="0">
                            <span class="date-time-text format-i18n">Использовать стандартную ссылку <b>"Удалить"</b></span>
                        </label>
                    </fieldset>
                </td>
            </tr>
            </tbody>
        </table>


        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Сохранить изменения"></p></form>

</div>
