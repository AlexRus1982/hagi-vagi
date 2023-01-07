<footer class="py-3 border-top">
    <div class="footer__container">
        <div class="wide-screen">
            <div class="fot">

                <div class="d-flex flex-column logo-and-c">
                    <img src="/images/logo_20201215105638.png" alt="logo" class="im">
                    <p class="c">© 2022. Все права защищены правообладателями</p>
                </div>

                <div class="stolbs">
                    <ul class="ps-0">
                    <li class="stb__head">КАТАЛОГ</li>

                        @if (Route::is('main'))
                        <? $parentId = 0; ?>
                        @else
                        <? 
                            if(isset($id)) {
                            $parentId = $id; 
                            }
                            else {
                            $parentId = 0;
                            }
                        ?>
                        @endif

                        <?php
                            $categories = DB::table('categories')
                            ->join('hierarchy_category', 'categories.id', '=', 'hierarchy_category.category_id')
                            ->where('parent_id', $parentId)
                            ->orderBy('order_place')
                            ->get();
                            foreach($categories as $category){
                              ?>
                                <li class="stb__item">{{$category->category_name}}</li>
                              <?
                            }
                        ?>
                        
                    </ul>
                    <ul class="ps-0">
                        <li class="stb__head">КОМПАНИЯ</li>
                        @php
                            $items = DB::table('services')->get();
                            foreach($items as $key => $value){
                                $value = (array)$value;
                                $pageUrl = "/service/{$value['url']}";
                                $pageName = $value['page_name'];
                                echo "<li><a class='stb__item' href='{$pageUrl}'>{$pageName}</a></li>";
                            }
                        @endphp
                    </ul>
                </div>
            </div>
        </div>

        <div class="short-screen">
            <div class="fot">
                <div class="stolbs" style="flex-direction: column;">
                    <ul class="ps-0">

                        <li class="stb__head">КАТАЛОГ</li>
                        @if (Route::is('main'))
                        <? $parentId = 0; ?>
                        @else
                        <? 
                            if(isset($id)) {
                            $parentId = $id; 
                            }
                            else {
                            $parentId = 0;
                            }
                        ?>
                        @endif

                        <?php
                            $categories = DB::table('categories')
                            ->join('hierarchy_category', 'categories.id', '=', 'hierarchy_category.category_id')
                            ->where('parent_id', $parentId)
                            ->orderBy('order_place')
                            ->get();
                            foreach($categories as $category){
                              ?>
                                <li class="stb__item">{{$category->category_name}}</li>
                              <?
                            }
                        ?>

                        <li class="stb__head">КОМПАНИЯ</li>
                        @php
                            $items = DB::table('services')->get();
                            foreach($items as $key => $value){
                                $value = (array)$value;
                                $pageUrl = "/service/{$value['url']}";
                                $pageName = $value['page_name'];
                                echo "<li><a class='stb__item' href='{$pageUrl}'>{$pageName}</a></li>";
                            }
                        @endphp
                    </ul>

                    <div class="d-flex flex-column logo-and-c">
                        <img src="/images/logo_20201215105638.png" alt="logo" class="im">
                        <p class="c">© 2022. Все права защищены правообладателями</p>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
</footer>