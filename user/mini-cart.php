                        <li class="mini-cart"><span><i class="icn-cart"></i>Корзина: <?php echo ($_SERVER['PHP_SELF'] == '/cart/complete/index.php' ? '0' : $_SESSION['item_total']); ?><span></li>
                        </ul>
                        <section class="mini-cart-container empty-cart">
                            <div class="mini-cart-arrow"></div>
                            <div class="mini-height-scroll-container">
                            	<span id="spinner_cart"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span>
                            </div>
                        </section>
