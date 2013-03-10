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
                    <div id="address">
                        <div class="field checkbox-field">
                            <input class="checkbox-input" type="checkbox" id="to-office" name="user-office">
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
</div>