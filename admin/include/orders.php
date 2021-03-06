<div class="ver-shadow-splitter"></div>
<div class="grid small-col">
    <aside class="progile-nav">
    <ul>
        <li><a href="#tabs-1" class="profile-nav-link selected">Добавить заказ <i class="icn-selected-nav"></i></a></li>
        <li><a href="#tabs-2" class="profile-nav-link">История заказов <i class="icn-selected-nav"></i></a></li>
        <li><a href="#tabs-3" class="profile-nav-link">Редактировать заказ <i class="icn-selected-nav"></i></a></li>
    </ul>
    </aside>
</div>
<div class="grid admin-size-col">
	<div class="almost-full-size-col centered tab" id="tabs-1">
        <form id="admin-add-order">
            <h2>Добавить заказ<span id="spinner-top"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span></h2>
            <div class="hor-splitter"></div>
            <div class="whiteboard grid">
            	<div class="small-col grid">
                    <input type="hidden" name="user-id" />
                    <div class="field">
                        <label for="user-phone">Телефон:</label>
                        <input type="hidden" name="user-phone-id" />
                        <input class="text-input user-search" type="tel" name="user-phone">
                    </div>
                    <div class="field">
                        <label for="user-name">Имя:</label>
                        <input class="text-input disabled" type="text" name="user-name">
                    </div>
                    <div class="field">
                        <label for="user-email">Email:</label>
                        <input class="text-input disabled" type="email" name="user-email">
                    </div>
                </div>
                <div class="big-col grid address-group">
                    <div class='field'>
                        <label for='user-address'>Адреса:</label>
                        <select class='text-input' name='user-address'>
                        </select>
                    </div>
                    <div class="field checkbox-field">
                        <input class="checkbox-input disabled" type="checkbox" id="to-office" name="user-office">
                        <label for="user-office">Доставка в офис</label>
                    </div>
                    <div class="field">
                        <label for="user-metro">Ближайшая станция метро:</label>
                        <input class="text-input disabled" type="text" tabindex="5" name="user-metro">
                    </div>
                    <div class="field">
                        <label for="user-street">Улица:</label>
                        <input class="text-input disabled" type="text" tabindex="6" name="user-street">
                    </div>
                    <div class="field group">
                        <div class="mini-field">
                            <label for="user-house">Дом:</label>
                            <input class="text-input disabled" type="text" tabindex="7" name="user-house">
                        </div>
                        <div class="mini-field">
                            <label for="user-building">Корпус:</label>
                            <input class="text-input disabled" type="text" tabindex="8" name="user-building">
                        </div>
                        <div class="mini-field">
                            <label for="user-flat">Квартира:</label>
                            <input class="text-input disabled" type="text" tabindex="9" name="user-flat">
                        </div>
                    </div>
                    <div class="field group">
                        <div class="mini-field">
                            <label for="user-enter">Подъезд:</label>
                            <input class="text-input disabled" type="text" tabindex="10" name="user-enter">
                        </div>
                        <div class="mini-field">
                            <label for="user-floor">Этаж:</label>
                            <input class="text-input disabled" type="text" tabindex="11" name="user-floor">
                        </div>
                        <div class="mini-field">
                            <label for="user-domofon">Домофон:</label>
                            <input class="text-input disabled" type="text" tabindex="12" name="user-domofon">
                        </div>
                    </div>
                    <div class="field company">
                        <label for="user-company">Название компании:</label>
                        <input class="text-input disabled" type="text" tabindex="13" name="user-company">
                    </div>
                </div>
            </div>
            <div class="whiteboard grid order-products">
                <table>
                    <thead>
                        <tr>
                            <td widtd="5%">&nbsp;</td>
                            <td widtd="50%">Наименование</td>
                            <td widtd="10%">Кол.</td>
                            <td widtd="15%">Цена</td>
                            <td widtd="15%">Всего</td>
                            <td widtd="5%">&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='admin-change-order-product'>
                            <td>1</td>
                            <td>
                                <div class="field">
                                    <input type="text" class="text-input product_search" name="product-name">
                                    <input type="hidden" name="product-id[]" />
                                </div>
                            </td>
                            <td><div class="field"><input type="number" class="text-input" name="product-amount[]"></div></td>
                            <td><div class="field"><input type="text" class="text-input disabled" name="product-price"></div></td>
                            <td><div class="field"><input type="text" class="text-input disabled" name="product-price-total"></div></td>
                            <td><span class="deleterow"></span></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td align="left" colspan="2"><span class="addrow">Добавить строку</span></td>
                            <td>Сумма:</td>
                            <td class="raw-bill">0.00</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td>Доставка:</td>
                            <td class="delivery">0.00</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td>Скидка:</td>
                            <td class="discount">0.00</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td>Всего к оплате:</td>
                            <td class="bill">0.00</td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="4">
                                <div class="field group">
                                    <div class="half-field">
                                        <label for="order-date">Дата доставки:</label>
                                        <input class="text-input" type="date" name="order-date">
                                    </div>
                                    <div class="half-field">
                                        <label for="order-time">Время доставки:</label>
                                        <select class="text-input" name="order-time">
                                            <option value="10:00-14:00" selected>10:00-14:00</option>
                                            <option value="14:00-18:00">14:00-18:00</option>
                                            <option value="18:00-22:00">18:00-22:00</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <div class="field">
                                    <label for="order-comment">Комментарий к заказу:</label>
                                    <textarea class="text-input" rows="5" name="order-comment"></textarea>
                                </div>
                            </td>
                            <td class="discount-5">&nbsp;</td>
                            <td class="discount-10">&nbsp;</td>
                            <td colspan="2">
                                <input type="hidden" name="order-discount" value="0" />
                                <div class="field"><a href="#" class="big-btn red-btn admin-add-order">Добавить заказ</a></div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="whiteboard grid full-size-col centered-text add-success">
            	<h2>Заказ добавлен</h2>
            </div>
        </form>
    </div>
	<div class="almost-full-size-col centered tab" id="tabs-2">
        <h2>История заказов<span id="spinner-top"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span></h2>
        <div class="hor-splitter"></div>
        <form id="admin-order-history">
            <div class="whiteboard grid half-col">
                <div class="full-size-col">
                    <div class="field order-datepicker">
                        <label for="order-date">Выберите дату доставки:</label>
                        <input class="text-input" type="date" name="order-date">
                    </div>
                </div>
                <div class="full-size-col admin-order-history-summary">
                	<div class="field group">
                        <div class="three-quaters-field">Количество кейков:</div>
                        <div class="one-quater-field total_cake_qty">0</div>
                    </div>
                	<div class="field group">
                        <div class="three-quaters-field">Общая сумма:</div>
                        <div class="one-quater-field total_sum">0</div>
                    </div>
                	<div class="field group">
                        <div class="three-quaters-field">Зарплата курьерам:</div>
                        <div class="one-quater-field courier_wage">0</div>
                    </div>
                	<div class="field group">
                        <div class="three-quaters-field">Прибыль:</div>
                        <div class="one-quater-field total_profit">0</div>
                    </div>
                </div>
            </div>
            <div class="whiteboard grid half-col hidden admin-order-history-cakes">
            </div>
            <div class="grid full-size-col order-history">
            </div>
        </form>
    </div>
	<div class="almost-full-size-col centered tab" id="tabs-3">
        <form id="admin-change-order">
            <h2>Редактировать заказ<span id="spinner-top"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span></h2>
            <div class="hor-splitter"></div>
            <div class="whiteboard grid">
            	<div class="small-col grid">
                    <input type="hidden" name="user-id" />
                    <div class="field">
                        <label for="user-phone">Телефон:</label>
                        <input type="hidden" name="user-phone-id" />
                        <input class="text-input user-search" type="tel" name="user-phone">
                    </div>
                    <div class="field">
                        <label for="user-name">Имя:</label>
                        <input class="text-input disabled" type="text" name="user-name">
                    </div>
                    <div class="field">
                        <label for="user-email">Email:</label>
                        <input class="text-input disabled" type="email" name="user-email">
                    </div>
                </div>
                <div class="big-col grid address-group">
                    <div class='field'>
                        <label for='user-address'>Адреса:</label>
                        <select class='text-input' name='user-address'>
                        </select>
                    </div>
                    <div class="field checkbox-field">
                        <input class="checkbox-input disabled" type="checkbox" id="to-office" name="user-office">
                        <label for="user-office">Доставка в офис</label>
                    </div>
                    <div class="field">
                        <label for="user-metro">Ближайшая станция метро:</label>
                        <input class="text-input disabled" type="text" tabindex="5" name="user-metro">
                    </div>
                    <div class="field">
                        <label for="user-street">Улица:</label>
                        <input class="text-input disabled" type="text" tabindex="6" name="user-street">
                    </div>
                    <div class="field group">
                        <div class="mini-field">
                            <label for="user-house">Дом:</label>
                            <input class="text-input disabled" type="text" tabindex="7" name="user-house">
                        </div>
                        <div class="mini-field">
                            <label for="user-building">Корпус:</label>
                            <input class="text-input disabled" type="text" tabindex="8" name="user-building">
                        </div>
                        <div class="mini-field">
                            <label for="user-flat">Квартира:</label>
                            <input class="text-input disabled" type="text" tabindex="9" name="user-flat">
                        </div>
                    </div>
                    <div class="field group">
                        <div class="mini-field">
                            <label for="user-enter">Подъезд:</label>
                            <input class="text-input disabled" type="text" tabindex="10" name="user-enter">
                        </div>
                        <div class="mini-field">
                            <label for="user-floor">Этаж:</label>
                            <input class="text-input disabled" type="text" tabindex="11" name="user-floor">
                        </div>
                        <div class="mini-field">
                            <label for="user-domofon">Домофон:</label>
                            <input class="text-input disabled" type="text" tabindex="12" name="user-domofon">
                        </div>
                    </div>
                    <div class="field company">
                        <label for="user-company">Название компании:</label>
                        <input class="text-input disabled" type="text" tabindex="13" name="user-company">
                    </div>
                </div>
            </div>
            <div class="whiteboard grid order-products hidden">
            </div>
            <div class="whiteboard grid full-size-col centered-text add-success">
            	<h2>Изменения сохранены</h2>
            </div>
            <div class="grid full-size-col order-history">
            </div>
        </form>
    </div>
</div>
