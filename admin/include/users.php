<div class="ver-shadow-splitter"></div>
<div class="grid small-col">
    <aside class="progile-nav">
    <ul>
        <li><a href="#tabs-1" class="profile-nav-link selected">Добавить пользователя <i class="icn-selected-nav"></i></a></li>
        <li><a href="#tabs-2" class="profile-nav-link">Изменить данные пользователя <i class="icn-selected-nav"></i></a></li>
    </ul>
    </aside>
</div>
<div class="grid admin-size-col">
	<div class="almost-full-size-col centered tab" id="tabs-1">
        <h2>Добавить пользователя<span id="spinner-top"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span></h2>
        <div class="hor-splitter"></div>
        <div class="whiteboard grid">
            <form id="admin-add-user">
                <div class="grid medium-col">
                    <h2>Личные данные</h2>
                    <div class="field">
                        <label for="user-name">Имя:</label>
                        <input class="text-input" type="text" name="user-name">
                    </div>
                    <div class="field">
                        <label for="user-phone">Телефон:</label>
                        <input class="text-input" type="tel" name="user-phone">
                    </div>
                </div>
                <div class="grid big-col">
                    <h2>Адрес</h2>
                    <div class="address-group">
                        <div class="field checkbox-field">
                            <input class="checkbox-input" type="checkbox" name="user-office">
                            <label for="user-office">Доставка в офис</label>
                        </div>
                        <div class="field">
                            <label for="user-metro">Ближайшая станция метро:</label>
                            <input class="text-input" type="text" name="user-metro">
                        </div>
                        <div class="field">
                            <label for="user-street">Улица:</label>
                            <input class="text-input" type="text" name="user-street">
                        </div>
                        <div class="field group">
                            <div class="mini-field">
                                <label for="user-house">Дом:</label>
                                <input class="text-input" type="text" name="user-house">
                            </div>
                            <div class="mini-field">
                                <label for="user-building">Корпус:</label>
                                <input class="text-input" type="text" name="user-building">
                            </div>
                            <div class="mini-field">
                                <label for="user-flat">Квартира:</label>
                                <input class="text-input" type="text" name="user-flat">
                            </div>
                        </div>
                        <div class="field group">
                            <div class="mini-field">
                                <label for="user-enter">Подъезд:</label>
                                <input class="text-input" type="text" name="user-enter">
                            </div>
                            <div class="mini-field">
                                <label for="user-floor">Этаж:</label>
                                <input class="text-input" type="text" name="user-floor">
                            </div>
                            <div class="mini-field">
                                <label for="user-domofon">Домофон:</label>
                                <input class="text-input" type="text" name="user-domofon">
                            </div>
                        </div>
                        <div class="field company">
                            <label for="user-company">Название компании:</label>
                            <input class="text-input" type="text" name="user-company">
                        </div>
                    </div>
                </div>
                <div class="grid full-size-col centered-text">
                    <div class="field"><a href="#" class="big-btn red-btn admin-add-user">Добавить пользователя</a></div>
                </div>
            </form>
        </div>
        <div class="whiteboard grid full-size-col centered-text add-success">
            <h2>Пользователь добавлен</h2>
        </div>
	</div>
	<div class="almost-full-size-col centered tab" id="tabs-2">
        <h2>Изменить данные пользователя<span id="spinner-top"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span></h2>
        <div class="hor-splitter"></div>
        <div class="whiteboard grid">
        	<form id="admin-change-user">
                <div class="small-col grid">
                    <input type="hidden" name="user-id" />
                    <div class="field">
                        <label for="user-phone">Телефон:</label>
                        <input type="hidden" name="user-phone-id[]" />
                        <input class="text-input user-search" type="tel" name="user-phone[]">
                    </div>
                    <div class="field">
                        <label for="user-name">Имя:</label>
                        <input class="text-input" type="text" name="user-name">
                    </div>
                    <div class="field">
                        <label for="user-email">Email:</label>
                        <input class="text-input" type="email" name="user-email">
                    </div>
                    <div class="hor-splitter"></div>
                    <div class="field">
                    	<label for="user-phone">Все телефоны:</label>
                    </div>
                    <div class="field">
                        <input type="hidden" name="user-phone-id[]" value="0">
                        <input class="text-input" type="tel" name="user-phone[]" placeholder="Добавить новый">
                    </div>
                </div>
                <div class="big-col grid address-group">
                    <div class="field">
                        <label for="user-address">Адреса:</label>
                        <select class="text-input" name="user-address">
                            <option value="0">-- Добавить адрес --</option>
                        </select>
                    </div>
                    <div class="field checkbox-field">
                        <input class="checkbox-input" type="checkbox" name="user-office">
                        <label for="user-office">Доставка в офис</label>
                    </div>
                    <div class="field">
                        <label for="user-metro">Ближайшая станция метро:</label>
                        <input class="text-input" type="text" tabindex="5" name="user-metro">
                    </div>
                    <div class="field">
                        <label for="user-street">Улица:</label>
                        <input class="text-input" type="text" tabindex="6" name="user-street">
                    </div>
                    <div class="field group">
                        <div class="mini-field">
                            <label for="user-house">Дом:</label>
                            <input class="text-input" type="text" tabindex="7" name="user-house">
                        </div>
                        <div class="mini-field">
                            <label for="user-building">Корпус:</label>
                            <input class="text-input" type="text" tabindex="8" name="user-building">
                        </div>
                        <div class="mini-field">
                            <label for="user-flat">Квартира:</label>
                            <input class="text-input" type="text" tabindex="9" name="user-flat">
                        </div>
                    </div>
                    <div class="field group">
                        <div class="mini-field">
                            <label for="user-enter">Подъезд:</label>
                            <input class="text-input" type="text" tabindex="10" name="user-enter">
                        </div>
                        <div class="mini-field">
                            <label for="user-floor">Этаж:</label>
                            <input class="text-input" type="text" tabindex="11" name="user-floor">
                        </div>
                        <div class="mini-field">
                            <label for="user-domofon">Домофон:</label>
                            <input class="text-input" type="text" tabindex="12" name="user-domofon">
                        </div>
                    </div>
                    <div class="field company">
                        <label for="user-company">Название компании:</label>
                        <input class="text-input" type="text" tabindex="13" name="user-company">
                    </div>
                </div>
                <div class="grid full-size-col centered-text">
                    <div class="field"><a href="#" class="big-btn red-btn admin-change-user">Сохранить изменения</a></div>
                </div>
            </form>
        </div>
        <div class="whiteboard grid full-size-col centered-text add-success">
            <h2>Данные сохранены</h2>
        </div>
        <div class="grid full-size-col order-history">
        </div>
    </div>
</div>